<?php
session_start();
require_once '../app/classes/Conexao.class.php';
require_once '../app/classes/Read.class.php';
require_once '../app/classes/Datas.class.php';
require_once '../app/config/get.inc.php';
require_once '../app/composer/vendor/autoload.php';
if(!isset($_SESSION['UserLogado']) || !$get):
    header("Location: https://localhost/syslab/index.php");
endif;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$sql        = new Read();



$sql->FullRead("SELECT EQ.patrimonio,
                        C.descricao equipamento,
                        F.nome_fabricante fabricante,
                        EQ.serie,
                        M.modelo,
                        L.local 
                    FROM tb_sys004 EQ
                        JOIN tb_sys008 L ON L.id = EQ.id_local
                        JOIN tb_sys018 F ON F.id_fabricante = EQ.fabricante
                        JOIN tb_sys022 M ON M.id_modelo = EQ.modelo
                        JOIN tb_sys003 C ON C.id = EQ.id_categoria AND EQ.id_local = 1 order by EQ.patrimonio");

$spreadsheet = new Spreadsheet(); //instanciando uma nova planilha

    $sheet = $spreadsheet->getActiveSheet(); //retornando a aba ativa
    $sheet->setCellValue('A1',"Patrimonio");
    $sheet->setCellValue('B1',"Equipamento");
    $sheet->setCellValue('C1',"Fabricante");
    $sheet->setCellValue('D1',"Serie");
    $sheet->setCellValue('E1',"Modelo");
    $sheet->setCellValue('F1',"local");
$i=1;
foreach ($sql->getResult() as $res):
    $sheet->setCellValue('A'.$i, $res['patrimonio']); 
    $sheet->setCellValue('B'.$i, $res['equipamento']); 
    $sheet->setCellValue('C'.$i, $res['fabricante']); 
    $sheet->setCellValue('D'.$i, $res['serie']); 
    $sheet->setCellValue('E'.$i, $res['modelo']);
    $sheet->setCellValue('F'.$i, $res['local']); 

    $i++;
endforeach;

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="myfile.xlsx"');
header('Cache-Control: max-age=0');
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
