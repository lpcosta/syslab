<?php
session_start();
require_once '../app/classes/Conexao.class.php';
require_once '../app/classes/Read.class.php';
require_once '../app/classes/Datas.class.php';
require_once '../app/composer/vendor/autoload.php';

if(!isset($_SESSION['UserLogado'])):
    header("Location: https://syslab.lpcosta.com.br/");
    exit();
endif;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$sql        = new Read();
$dt         = new Datas();
$hoje  = date('d/m/Y');

$sheet = 0;

function random_color() {
    $letters = '0123456789ABCDEF';
    for($i = 0; $i < 6; $i++) {
        $index = rand(0,15);
       $letters[$i] = $index;
    }
    return substr($letters, 0, 6); // abcd$letters;
}
// Instanciamos a classe
$objPHPExcel = new Spreadsheet();

// defini as propriedades do documento
$objPHPExcel->getProperties()->setCreator("Syslab")
        ->setLastModifiedBy("Leandro Pereira")
        ->setTitle("aguardo de peça psa")
        ->setSubject("peças do projeto psa")
        ->setDescription("planilha de cotação de peças do projeto de Santo André");

$objPHPExcel->getDefaultStyle()
        ->getAlignment()
        ->setHorizontal(PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// Define a planilha ativa para o PHPExcel operar
$objPHPExcel->setActiveSheetIndex($sheet)->getTabColor()->setRGB('FF00FF');
// Adicionamos um estilo de A1 até M1 
$objPHPExcel->getActiveSheet()->getStyle('A1:B1')->applyFromArray(
        array('fill' => array(
                'type' => PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => array('rgb' => 'E0EEEE')
            ),
        )
);
$objPHPExcel->getActiveSheet()->getStyle('A3:B3')->applyFromArray(
        array('fill' => array(
                'type' => PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => array('rgb' => 'E0EEEE')
            ),
        )
);
$objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
$objPHPExcel->getActiveSheet()->mergeCells('A3:B3');
// Define o título da planilha 

$objPHPExcel->getActiveSheet()->setTitle('RESUMO');

$sql->FullRead("SELECT id FROM tb_sys006 WHERE status = :STS","STS=5");
$total = $sql->getRowCount();

$objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setSize(14)->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A2:B2')->getFont()->setSize(12)->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A3:B3')->getFont()->setSize(12)->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A4:B4')->getFont()->setSize(11)->setBold(true);

$objPHPExcel->setActiveSheetIndex($sheet)
        ->setCellValue('A1', 'RESUMO DESSA SOLICITAÇÃO')
        ->setCellValue('A2', "QUANTIDADE DE EQUIPAMENTO");


$objPHPExcel->getActiveSheet()->setCellValue('B2', $total);
$objPHPExcel->getActiveSheet()->setCellValue('A' . 3, " QUANTIDADE POR EQUIPAMENTO ");

$objPHPExcel->setActiveSheetIndex($sheet)
        ->setCellValue('A4', 'EQUIPAMENTO')
        ->setCellValue('B4', "TOTAL");
$sql->FullRead("SELECT C.descricao equipamento,count(*) total 
                    FROM tb_sys004 EQ
                        JOIN tb_sys003 C ON C.id = EQ.id_categoria
                        JOIN tb_sys006 IE ON IE.patrimonio = EQ.patrimonio AND IE.status = :STS group by C.id order by C.descricao","STS=5");
$i = 5;
foreach ($sql->getResult() as $row) {
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, strtoupper($row['equipamento']));
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $row['total']);

    $i++;
}

$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setWrapText(true)->setHorizontal(PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setWrapText(true)->setVertical(PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(60);

$sql->FullRead("SELECT C.descricao,C.id
                                FROM tb_sys003 C 
                                JOIN tb_sys004 EQ ON EQ.id_categoria = C.id
                                JOIN tb_sys006 IE ON IE.patrimonio = EQ.patrimonio AND IE.status = :STS GROUP BY C.id ORDER BY id","STS=5");

$sheet +=1;
$cor = random_color();
  foreach ($sql->getResult() as $categ):
/* BUSCANDO IMPRESSORAS CATEGORIA 1 */
$sql->FullRead("SELECT 
                    IE.os_sti os,
                    EQ.patrimonio,
                    C.descricao equipamento,
                    M.modelo,
                    F.nome_fabricante fabricante,
                    A.avaliacao,
                    L.local localidade,
                    P.id_peca codigo,
                    E.data,
                    P.descricao_peca peca 
                FROM tb_sys004 EQ
                        JOIN
                    tb_sys006 IE ON IE.patrimonio = EQ.patrimonio
                        JOIN
                    tb_sys022 M ON M.id_modelo = EQ.modelo
                        JOIN
                    tb_sys005 E ON E.identrada = IE.id_entrada
                        JOIN
                    tb_sys018 F ON F.id_fabricante = EQ.fabricante
                        JOIN
                    tb_sys010 A ON A.id_item_entrada = IE.id
                        JOIN
                    tb_sys015 P ON P.id_peca = A.peca_id
                        JOIN
                    tb_sys001 T ON T.id = A.id_tecnico_bancada
                        JOIN
                    tb_sys008 L ON L.id = EQ.id_local
                        JOIN
                    tb_sys003 C ON C.id = EQ.id_categoria AND IE.status = A.id_status AND A.id_status = :STS AND C.id = :CATEG ORDER BY E.data","STS=5&CATEG={$categ['id']}");

        // Criando uma nova planilha dentro do arquivo
        $objPHPExcel->createSheet();
        // Define a planilha ativa para o PHPExcel operar
        $objPHPExcel->setActiveSheetIndex($sheet)->getTabColor()->setRGB($cor);
        // Adicionamos um estilo de A1 até F1 
        $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray(
                array('fill' => array(
                        'type' => PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => array('rgb' => 'E0EEEE')
                    ),
                )
        );

        $objPHPExcel->getActiveSheet()->mergeCells('A1:H1');

        // Define o título da planilha 
        $objPHPExcel->getActiveSheet()->setTitle(strtoupper($categ['descricao']));
        $objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setAutoFilter('A2:H2');

        // Define a largura das colunas de modo automático
        #$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);

        $objPHPExcel->setActiveSheetIndex($sheet)
                ->setCellValue('A1', 'AGUARDO DE PEÇAS -' . date('d/m/Y'))
                ->setCellValue('A2', "CÓDIGO")
                ->setCellValue("B2", "PEÇA")
                ->setCellValue("C2", "EQUIPAMENTO")
                ->setCellValue("D2", "OS")
                ->setCellValue("E2", "PATRIMONIO")
                ->setCellValue("F2", "LOCALIDADE")
                ->setCellValue("G2", "PENDÊNCIA")
                ->setCellValue("H2", "AVALIAÇÃO");
        $i = 3;
        foreach ($sql->getResult() as $res) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $res['codigo']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $res['peca']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $res['equipamento'] . ' ' . $res['fabricante'] . ' ' . $res['modelo']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $res['os']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $res['patrimonio']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $res['localidade']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $dt->setData($res['data'], $hoje)  . " Dias");
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $res['avaliacao']);
            $i++;
        }

        $objPHPExcel->getActiveSheet()->getStyle('A3:J1000')->getAlignment()->setWrapText(true)->setVertical(PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B3:J1000')->getAlignment()->setWrapText(true)->setVertical(PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C3:J1000')->getAlignment()->setWrapText(true)->setVertical(PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D3:J1000')->getAlignment()->setWrapText(true)->setVertical(PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F3:J1000')->getAlignment()->setWrapText(true)->setVertical(PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G3:J1000')->getAlignment()->setWrapText(true)->setVertical(PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('H3:F1000')->getAlignment()->setWrapText(true)->setVertical(PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(50);


        $objPHPExcel->getActiveSheet()->mergeCells('A' . $i . ':' . 'H' . $i);
        $i += 1;
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $i . ':' . 'H' . $i);

        $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':' . 'H' . $i)->getFont()->setBold(true);

        $sql->FullRead("SELECT P.id_peca codigo,
                            P.descricao_peca peca,
                            count(*) quantidade 
                        FROM tb_sys015 P 
                            JOIN tb_sys010 A ON A.peca_id = P.id_peca
                            JOIN tb_sys006 IE ON IE.id = A.id_item_entrada
                            JOIN tb_sys004 EQ ON EQ.patrimonio = IE.patrimonio AND EQ.id_categoria = :CATEG AND A.id_status = :STS group by P.id_peca order by quantidade desc","CATEG={$categ['id']}&STS=5");

        $ir = $i+1;
        $objPHPExcel->setActiveSheetIndex($sheet)
                ->setCellValue("A" . $i, "RESUMO DESSA SOLICITAÇÃO")
                ->setCellValue("A" . $ir, "CÓDIGO")
                ->setCellValue("B" . $ir, "PEÇA")
                ->setCellValue("C" . $ir, "QUANTIDADE");
        $objPHPExcel->getActiveSheet()->getStyle('A' . $ir . ':' . 'D' . $ir)->getFont()->setBold(true);
        $ir +=1;
        foreach ($sql->getResult() as $res) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $ir, $res['codigo']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $ir, $res['peca']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $ir, $res['quantidade']);
            $ir++;
        }
    $sheet++;
    $cor = random_color();
endforeach;

// Define a planilha como ativa sendo a primeira, assim quando abrir o arquivo será a que virá aberta como padrão
$objPHPExcel->setActiveSheetIndex(0);
// Salva  o arquivo 
// Cabeçalho do arquivo para ele baixar
$arquivo = "SOLICITAÇÃO_DE_PEÇAS_PSA_".date('d-m-Y');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$arquivo.'".xlsx"');
header('Cache-Control: max-age=0');
// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');
$writer = new Xlsx($objPHPExcel);
$writer->save('php://output');
exit;
