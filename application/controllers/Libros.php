<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Libros extends CI_Controller {

	public function index()
	{
		$data['LibrosPrestados'] = $this->db->query("SELECT
				P.ID_Prestamo
				,P.ID_Producto_Biblioteca
				,PR.Nombre AS Producto
				,CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(T.Nombre_1,' '),T.Nombre_2),' '),T.Apellido_1),' '),T.Apellido_2) AS Nombre
			FROM Prestamo P
			LEFT JOIN Producto_Biblioteca PB ON P.ID_Producto_Biblioteca = PB.ID_Producto_Biblioteca
			LEFT JOIN Producto PR ON PB.ID_Producto = PR.ID_Producto
			LEFT JOIN Usuario U ON P.ID_Usuario = U.ID_Usuario
			LEFT JOIN Tercero T ON U.ID_Tercero = T.ID_Tercero
			WHERE P.FechaEntregaReal IS NULL")->result();
		$data['Clientes'] = $this->db->query("
			SELECT X.ID_Usuario, X.NOMBRE, X.ROL, X.PLAZO_MAX
			FROM (
				SELECT
				    U.ID_Usuario
				    ,CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(T.Nombre_1,' '),T.Nombre_2),' '),T.Apellido_1),' '),T.Apellido_2) AS Nombre
				    ,TU.Nombre AS Rol
				    ,TU.Plazo_max
				    ,CASE WHEN U.ID_Usuario IN (
				        SELECT
				            P.ID_Usuario
				        FROM Pago P
				        WHERE CURDATE() BETWEEN P.Fecha AND DATE_ADD(P.Fecha, INTERVAL 12 MONTH)
				    ) THEN 1 ELSE 0 END AS PagoAnual
				    ,CASE WHEN P.ProductosPrestados IS NULL THEN 0 ELSE P.ProductosPrestados END AS ProductosPrestados
				    ,CASE WHEN PA.ProductosPrestados IS NULL THEN 0 ELSE PA.ProductosPrestados END AS ProductosAtrasados
				    ,CASE WHEN S.SancionesActivas > 0 THEN 1 ELSE 0 END AS SancionActiva
				    ,CASE WHEN S.Deuda IS NULL THEN 0 ELSE (S.Deuda + (CAST(CURDATE() - S.Fecha AS INT) * (SELECT Costo_Incremento FROM Parametro))) END AS Deuda
				FROM Usuario U
				    LEFT JOIN Tercero T ON U.ID_Tercero = T.ID_Tercero
				    LEFT JOIN Tipo_Usuario TU ON U.ID_Tipo_Usuario = TU.ID_Tipo_Usuario
				    LEFT JOIN (SELECT
				        ID_Usuario
				        ,COUNT(*) AS ProductosPrestados
				    FROM Prestamo
				    WHERE FechaEntregaReal IS NULL
				    GROUP BY ID_Usuario) P ON U.ID_Usuario = P.ID_Usuario
				    LEFT JOIN (SELECT
				        ID_Usuario
				        ,COUNT(*) AS ProductosPrestados
				    FROM Prestamo
				    WHERE FechaEntregaReal IS NULL
				    AND CURDATE() > FechaEntregaEstimada
				    GROUP BY ID_Usuario) PA ON U.ID_Usuario = P.ID_Usuario
				    LEFT JOIN (SELECT
				        ID_Usuario
				        ,COUNT(*) AS SancionesActivas
				        ,SUM(VALOR) AS Deuda
				        ,MIN(FechaInicio) AS Fecha
				    FROM Sancion
				    WHERE DATE_ADD(FechaInicio, INTERVAL 1 MONTH) > CURDATE()
				    GROUP BY ID_Usuario) S ON U.ID_Usuario = S.ID_Usuario
				ORDER BY
				    CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(T.Nombre_1,' '),T.Nombre_2),' '),T.Apellido_1),' '),T.Apellido_2) ASC
				    ,TU.Nombre ASC
			)X
			WHERE
				X.PAGOANUAL = 1
				AND X.DEUDA = 0
				AND X.SancionActiva = 0
				AND X.ProductosAtrasados = 0
				AND X.ProductosPrestados <= (SELECT Limite_UsuarioAdquirido FROM Parametro)
		")->result();

		$data['Productos'] = $this->db->query("SELECT
			PB.ID_Producto_Biblioteca
		    ,B.Nombre AS Biblioteca
		    ,P.Nombre AS Producto
		    ,C.Nombre AS Categoria
		    ,TP.Nombre AS Tipo
		    ,PB.Prestamo
		    ,PB.Ubicacion
		FROM Producto_Biblioteca PB
		    LEFT JOIN Biblioteca B ON PB.ID_Biblioteca = B.ID_Biblioteca
		    LEFT JOIN Producto P ON PB.ID_Producto = P.ID_Producto
		    LEFT JOIN Categoria C ON P.ID_Categoria = C.ID_Categoria
		    LEFT JOIN Tipo_Producto TP ON P.ID_Tipo_Producto = TP.ID_Tipo_Producto
		WHERE PB.ID_Producto_Biblioteca
    		NOT IN (SELECT ID_Producto_Biblioteca FROM Prestamo WHERE FechaEntregaReal IS NULL)
		ORDER BY
		    B.Nombre ASC
		    ,P.Nombre ASC
		    ,C.Nombre ASC
		    ,TP.Nombre ASC")->result();
		$this->load->view('vLibros',$data);
	}

	function prestamo(){
		$ID_Usuario = $this->input->post('ID_Usuario');
		$Libro = $this->input->post('Libro');
		$ID_Prestamo = $this->db->query("SELECT MAX(ID_Prestamo)+1 AS ID FROM Prestamo")->row('ID');
		$Plazo_Max = $this->db->query("SELECT TU.Plazo_Max FROM Usuario U LEFT JOIN Tipo_Usuario TU ON U.ID_Tipo_Usuario = TU.ID_Tipo_Usuario WHERE U.ID_Usuario = '$ID_Usuario'")->row('Plazo_Max');
		$this->db->query("INSERT INTO Prestamo (ID_Prestamo, FechaPrestamo, FechaEntregaEstimada, ID_Producto_Biblioteca, ID_Usuario) VALUES
		('$ID_Prestamo', CURDATE(), DATE_ADD(CURDATE(), INTERVAL ".$Plazo_Max." DAY), '$Libro', '$ID_Usuario')");
	}

	function entrega(){
		$ID = $this->input->post('ID');
		$FechaEntregaEstimada = $this->db->query("SELECT FechaEntregaEstimada FROM Prestamo WHERE ID_Prestamo = '$ID'")->row('FechaEntregaEstimada');
		$ID_Usuario = $this->db->query("SELECT ID_Usuario FROM Prestamo WHERE ID_Prestamo = '$ID'")->row('ID_Usuario');
		$this->db->query("UPDATE Prestamo SET FechaEntregaReal = CURDATE() WHERE ID_Prestamo = '$ID'");
		if(date('Y-m-d') > $FechaEntregaEstimada){
			$ID_Retraso = $this->db->query("SELECT MAX(ID_Retraso)+1 AS ID FROM Retraso")->row('ID');
			$this->db->query("INSERT INTO Retraso (ID_Retraso, Fecha, ID_Usuario) VALUES ('$ID_Retraso', CURDATE(), '$ID_Usuario')");
			$consulta = $this->db->query("SELECT * FROM Retraso WHERE YEAR(Fecha) = YEAR(CURDATE()) AND ID_Usuario = '$ID_Usuario'")->result();
			if(count($consulta > 2)){
				$ID_Sancion = $this->db->query("SELECT MAX(ID_Sancion)+1 AS ID FROM Sancion")->row('ID');
				$this->db->query("INSERT INTO Sancion (ID_Sancion, Valor, FechaInicio, ID_Usuario) VALUES ('$ID_Sancion', (SELECT Costo_Sancion FROM Montaje), CURDATE(), '$ID_Usuario')");
			}
		}
	}
}
