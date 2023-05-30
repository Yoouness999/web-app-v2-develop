<?php namespace Modules\Labelmanager\Http\Controllers;

use Arxmin;
use Config;
use Hook;
use Input;
use Lang;
use Modules\Labelmanager\Entities\Label;
use PHPExcel;
use PHPExcel_IOFactory;

class LabelManagerController extends Arxmin\ModuleController
{
    /**
     * Label homepage
     *
     * @return \Illuminate\View\View
     */
    public function anyIndex()
    {
        Arxmin\Module::setCurrent('labelmanager');

        $title = __('Labels');

        $apiRoute = "/arxmin/modules/labelmanager/api";
        $moduleUrl = "/arxmin/modules/labelmanager/";
        $moduleAssets = "/modules/labelmanager/";

        Hook::put('__app.ajax.create.url', $apiRoute . '/label/create');
        Hook::put('__app.ajax.read.url', $apiRoute . '/label');
        Hook::put('__app.ajax.update.url', $apiRoute . '/label/update');
        Hook::put('__app.ajax.delete.url', $apiRoute . '/label/delete');

        $locales = Label::getLocales();

        Hook::put('__app.locales', $locales);

        return $this->viewMake('labelmanager::index', get_defined_vars());
    }

    /**
     * Import labels from an Excel to Labels table
     *
     */
    public function anyImport()
    {
        // Check if file is defined
        if (count($_FILES)) {
            foreach ($_FILES as $key => $value) {
                $oExcel = PHPExcel_IOFactory::load($value['tmp_name']);
                $oSheet = $oExcel->getSheet(0);
                $iRow = 1;

                // Define columns data
                $columns = [];

                $i = 0;
                while ($value = $oSheet->getCellByColumnAndRow($i, $iRow)->getValue()) {
                    $columns[$i] = $value;
                    $i++;
                }

                $iRow++;

                # 1. populate data from columns
                $data = [];

                foreach ($columns as $key => $name) {
                    $data[$name] = $oSheet->getCellByColumnAndRow($key, $iRow)->getValue();
                    // force int
                    if ($name == 'id') {
                        $data[$name] = (int) ($data[$name]);
                    }
                }

                while (array_filter($data)) {

                    if ($data['id']) {
                        $label = Label::find($data['id']);
                    } else {
                        $label = new Label();
                    }

                    array_splice($data, 0, 1);

                    foreach ($data as $key => $value) {
                        $label->{$key} = $value;
                    }

                    $label->save();

                    // Repopulate data
                    $iRow++;
                    $data = [];
                    foreach ($columns as $key => $name) {
                        $data[$name] = $oSheet->getCellByColumnAndRow($key, $iRow)->getValue();
                        // force int
                        if ($name == 'id') {
                            $data[$name] = (int) ($data[$name]);
                        }
                    }
                }
            }
        } /*else {
            return redirect('/arxmin/modules/labelmanager')->withErrors(lg('labelmanager::errors.import'));
        }*/

        return redirect('/arxmin/modules/labelmanager');
    }

    /**
     * Export labels in an Excel from labels table
     *
     */
    public function anyExport()
    {
        $data = Label::all()->toArray();
        // Return the columns name dynamically
        array_unshift($data, array_keys($data[0]));

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("Labels");

        // Put labels data inside the first sheet
        $objPHPExcel->setActiveSheetIndex(0)
            ->fromArray($data);
        $objPHPExcel->getActiveSheet()->setTitle('Labels');
        $objPHPExcel->setActiveSheetIndex(0);

        // Set header for xls output
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="labels.xls"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        exit;
    }
}