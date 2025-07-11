<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelController extends Controller
{
    public function renderExcel(Request $request)
    {

        $file = $request->file('file');

        $excel = IOFactory::load($file);

        $sheets = [];

        $numberSheet = $excel->getSheetCount();


        $sheetIndex = 0;

        for ($sheetIndex = 0; $sheetIndex < $numberSheet; $sheetIndex++) {

            $rowData = [];
            $sheet = $excel->getSheet($sheetIndex);

            // Get the sheet name
            $sheetName = $sheet->getTitle();

            // Get the highest row number that contains data
            $highestRow = $sheet->getHighestDataRow();

            // Get the highest column letter that contains data
            $highestColumn = $sheet->getHighestDataColumn();

            // Convert the column letter to a column index (0-based)
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);


            // Loop through each row and column to get the cell values

            for ($row = 1; $row <= $highestRow; $row++) {

                $rowHeight = $sheet->getRowDimension($row)->getRowHeight();
                $r = ["height"=>$rowHeight*1.4];

                $cells = [];
                for ($col = 1; $col <= $highestColumnIndex; $col++) {
                    $curentCell =   $sheet->getCellByColumnAndRow($col, $row);

                    $wrap = $curentCell->getStyle()->getAlignment()->getWrapText();
                    $colSpan = $curentCell->getMergeRange();

                    $style = [];
                    $cellValue = $curentCell->getValue();
                    $styleCell = $curentCell->getStyle();



                    $style['backgroundColor'] = '#'.$styleCell->getFill()->getStartColor()->getRGB();
                    $style['fontFamily'] = "TimesNewRoman";

                    if ($curentCell->getStyle()->getBorders()->getTop()->getBorderStyle() != 'none'){
                        $style['borderTop'] = '1px solid #000000';
                    }
                    if ($curentCell->getStyle()->getBorders()->getBottom()->getBorderStyle() != 'none'){
                        $style['borderBottom'] = '1px solid #000000';
                    }
                    if ($curentCell->getStyle()->getBorders()->getRight()->getBorderStyle() != 'none'){
                        $style['borderLeft'] = '1px solid #000000';

                    }
                    if ($curentCell->getStyle()->getBorders()->getLeft()->getBorderStyle() != 'none'){
                        $style['borderRight'] = '1px solid #000000';
                    }


                    if ($styleCell->getFont()->getBold()){
                        $style['fontWeight'] = 'Bold';
                    }

                    if ( $styleCell->getFont()->getSize()){
                        $style['fontSize'] = $styleCell->getFont()->getSize().'pt';
                    }
                    if ( $styleCell->getAlignment()->getVertical()){
                        $style['verticalAlign'] = $styleCell->getAlignment()->getVertical() == 'center' ? 'Middle' : ucfirst($styleCell->getAlignment()->getVertical());
                    }
                    if ( $styleCell->getAlignment()->getHorizontal()){
                        $style['textAlign'] = ucfirst($styleCell->getAlignment()->getHorizontal());
                    }
                    if ($cellValue instanceof \PhpOffice\PhpSpreadsheet\RichText\RichText) {
                        $text = '';
                        foreach ($cellValue->getRichTextElements() as $richTextElement) {
                            $text.=$richTextElement->getText().' ';
//                            var_dump($richTextElement->getFont()->getBold());
                        }
                        $cell = [
                            'wrap' => $wrap,
                            'value' => $text,
                            "isLocked" => true,
                            "format" => '@',
                            "style" => (object) $style,
                        ];
                        if ($colSpan && $this->checkMergedCell($curentCell,$colSpan)){
                            if (count($sheet->rangeToArray($colSpan)) > 1){
                                $cell['rowSpan'] = count($sheet->rangeToArray($colSpan));
                            }
                            if (count(($sheet->rangeToArray($colSpan))[0]) > 1){
                                $cell['colSpan'] = count(($sheet->rangeToArray($colSpan))[0]);
                            }
                        }
                    }
                    else{
                        $cell = [
                            'wrap' => $wrap,
                            'value' => $cellValue,
                            "isLocked" => true,
                            "format" => '@',
                            "style" => (object) $style,
                        ];
                        if ($colSpan && $this->checkMergedCell($curentCell,$colSpan)){
                            if (count($sheet->rangeToArray($colSpan)) > 1){
                                $cell['rowSpan'] = count($sheet->rangeToArray($colSpan));
                            }
                            if (count(($sheet->rangeToArray($colSpan))[0]) > 1){
                                $cell['colSpan'] = count(($sheet->rangeToArray($colSpan))[0]);
                            }
                        }
                    }

                    array_push($cells,(object)$cell);

                }
                $r["cells"] = $cells;


                array_push($rowData,(object)$r);
            }



// Get the used range
            $usedRange = $sheet->calculateWorksheetDimension();

            $columns = [];


            $defaultColumnWidthInPixels = 7;
            for ($col = 1; $col <= $highestColumnIndex; $col++) {
                $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
                $columnWidth = $sheet->getColumnDimension($columnLetter)->getWidth() * $defaultColumnWidthInPixels;
                if ($col == 0) {
                    array_push($columns, (object)[
                        'width' => $columnWidth
                    ]);
                } else {
                    array_push($columns, (object)[
                        'index' => $col - 1,
                        'width' => round($columnWidth)
                    ]);
                }

            }

            $sheet = [
                'name' => $sheetName,
                'selectedRange' => '',
                'usedRange' => (object)[
                    "colIndex" => $highestColumnIndex,
                    "rowIndex" => $highestRow
                ],
                "columns" => $columns,
                "rows"=>$rowData
            ];
            array_push($sheets, $sheet);
        }


// Return the sheet names as an array


        return response()->json([
            'Workbook' => [
                'definedNames' => [],
                'filterCollection' => [],
                'sortCollection' => [],
                'sheets' => $sheets
            ]
        ]);
    }

    protected function checkMergedCell($cell,$colSpan){
        $currentCell = $cell->getCoordinate();
        $letter = explode(':',$colSpan);

        if ($currentCell == $letter[0]) return true;


        return false;
    }
}
