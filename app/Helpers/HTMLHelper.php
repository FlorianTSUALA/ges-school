<?php

namespace App\Helpers;

use App\Model\FrequentlyReapeat;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;

trait HTMLHelper
{

    public static function formatHeader($title) {
        return ucwords(str_replace('_', ' ', helpers::toCamelCase($title)));
    }

    public static function formatFieldTable($title) {
        return ucwords(str_replace('_', ' ', helpers::toCamelCase($title)));
    }

    public static function genHeaderTable($headerItems) {
        $html  = '<tr>';
        $html .= '   <th>N°</th>';
        foreach($headerItems as $headerItem){
            $html .= '  <th>' . $headerItem . '</th>';
            // $html .= '  <th>' . helpers::formatHeader($headerItem) . '</th>';
        }
        $html .= '   <th>Actions</th>';
        $html .= '</tr>';
        return $html;
    }

    public static function genBodyTable($items, $className, $headerItems) {
        $html = '';
        $i = 0;
        //var_dump($items, $headerItems); die();
        if(isset($items) && is_array($items) && count($items)>0)
            foreach($items as $item):
                $html .= helpers::genRowBodyTable(++$i, $item, $headerItems);
            endforeach; 
        else
            $html .=
                '<tr>
                    <div class="alert alert-warning mb-2" role="alert">
                        <strong>Oups!</strong> Table vide, aucune données enrigistrées.
                    </div>
                </tr>';
        return $html;
    }

    public static function genRowBodyTable($i, $model, $headerItems)
    {
        
       // var_dump($model, $headerItems);
        $model = Helpers::object_to_array($model);
        $headerItems = Helpers::object_to_array($headerItems);

        $html = '<tr>';
        $html .= '  <td>'. $i .'</td>';
        //var_dump($model, $headerItems);
        //die();
        
        foreach($headerItems as $headerItem)
        {
            $headerItem = Helpers::object_to_array($headerItem);
            $headerItem = Helpers::object_to_array($headerItem);
            $html .= '  <td  style="word-wrap: break-word;min-width: 20px;max-width: 200px;">' . helpers::formatToReadableOutput($model[$headerItem[FormModel::NAME]], $headerItem[FormModel::EXTERNAL_TYPE]) . '</td>';
        }
    
        $html .= '   <td width="20%">
                        <button data-id="'. $model[FrequentlyReapeat::CODE] .'" type="button" class=" btn_delete_data btn btn-sm btn-danger"><i class="ft-trash-2"></i></button>
                        <button data-id="'. $model[FrequentlyReapeat::CODE] .'" type="button" class=" btn_update_data btn btn-sm btn-green"><i class="ft-edit-2"></i></button>
                        <button data-id="'. $model[FrequentlyReapeat::CODE] .'" type="button" class=" btn_read_data btn btn-sm btn-blue"><i class="ft-eye"></i></button>
                    </td>';
        $html .= '</tr>';
        return $html;
    }

    public static function buildDetailModel($model, $headerItems){
        $html = '<div class="table-responsive" style="width:100%;height:100%;" >
                    <table class="table table-white-space no-wrap table-middle mb-0"  style="width:100%;height:100%; margin: 0 auto;">
                        <tbody>
                            '.helpers::buildItemDetailModel($model, $headerItems).'
                        </tbody>
                    </table>
                </div>';
            return $html;
    }

    public static function buildItemDetailModel($model, $headerItems){
        $html = '';

        $model = Helpers::object_to_array($model);
        $headerItems = Helpers::object_to_array($headerItems);
        
        foreach($headerItems as $headerItem){
            $html .= '<tr>
                        <td>
                            <p class="text-bold-600 align-middle">'.$headerItem[FormModel::LABEL].' : </p>
                        </td>
                        <td >
                            <pre class="language-markup">'.helpers::formatToReadableOutput($model[$headerItem[FormModel::NAME]], $headerItem[FormModel::EXTERNAL_TYPE]).'</pre>
                        </td>
                    </tr>';
        }
        return $html;
    }

    public static function formatToReadableOutput($value, $type){
        switch($type){
            case InputType::TEXT:
                return $value;
            case InputType::EMAIL:
                return $value;
            case InputType::PASSWORD:
                return $value;
            case InputType::HIDDEN:
                return $value;
            case InputType::NUMBER:
                return $value;
            case InputType::FILE:
                return $value;
            case InputType::DATE:
                return Helpers::getFullDate($value);
            case InputType::DATE_DAY:
                return Helpers::getFullDay($value);
            case InputType::DATE_MONTH:
                return Helpers::getFullMonth($value);
            case InputType::DATE_YEAR:
                return Helpers::getFullYear($value);
            case InputType::DATE_TIME_LOCAL:    
                return Helpers::getFullDateTime($value);
            case InputType::TIME:
                return $value;
            case InputType::TEL:
                return $value;
            case InputType::CHECKBOX:
                return $value;
            case InputType::TEXTAREA:
                return $value;
            default:
                return $value;
        }
    
    }

    public static function required_input()
    {
        echo "<strong class='text-danger font-weight-bolder h5'>*</strong>&nbsp;";
    }
    
    public static function required_input_text()
    {
        return "<strong class='text-danger font-weight-bolder h5'>*</strong>&nbsp;";
    }

    public static function getOld($dateborn)
    {
        $dateborn = date_create($dateborn);
        $old = date("Y") - date_format($dateborn,"Y");

        return ($old < 0) ? false : $old;
    }

    public static function dataTableResponsibleSearchBar(){
        $style = " 
                    <style>
                    // .dataTables_filter {
                    //     width: 50%;
                    //     float: right;
                    //     text-align: right;
                    // }

                    // @media (max-width: 768px) { /* use the max to specify at each container level */
                    // .specifictd {    
                    //     width:360px;  /* adjust to desired wrapping */
                    //     display:table;
                    //     white-space: pre-wrap; /* css-3 */
                    //     white-space: -moz-pre-wrap; /* Mozilla, since 1999 */
                    //     white-space: -pre-wrap; /* Opera 4-6 */
                    //     white-space: -o-pre-wrap; /* Opera 7 */
                    //     word-wrap: break-word; /* Internet Explorer 5.5+ */
                    //     }
                    // }

                    .word-wrap {
                        word-break: break-all;
                    // word-wrap: break-word;
                    // overflow-wrap: break-word;
                    }
                </style>
         ";
         return $style;
    }

    public static function dataTableCommunOptions(){
        $options = " dom:
                        \"<'d-flex justify-content-between'<'p-2'l><'p-2'f>>\" +
                        \"<'row'<'col-sm-12'tr>>\" +
                        \"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>\",
                    language: {
                        'scrollY': '1000px',
                        'scrollCollapse': true,
                        'scrollX': true,
                        //'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Tout']],
                        'iDisplayLength': -1,
                        'lengthMenu': 'Afficher _MENU_ éléments par page',
                        'zeroRecords': 'Oups... Aucune données disponible',
                        'info': 'Page _PAGE_ sur _PAGES_',
                        'infoEmpty': 'Aucun enregistrement disponible',
                        'infoFiltered': '(filtre appliqué sur _MAX_ éléments au total du tableau actuel)',
                        'decimal': ',',
                        'thousands': ' ',
                        'paginate': {
                            'first': 'Premier',
                            'last': 'Dernier',
                            'next': 'Suiv.',
                            'previous': 'Préc.'
                        },
                        'search': 'Zone de recherche : &nbsp; &nbsp; &nbsp;',
                        'searchPlaceholder': 'entrer un mot clé',
                        buttons: {
                            colvis: '<i class=\"fa fa-eye\" aria-hidden=\"true\"></i>Visibilité',
                            copy: '<span class=\"i-Stamp-1\">Copiez</span>',
                            print: '<span class=\"i-Stamp-1\">Imprimez</span>',
                            copyTitle: 'Ajouté au presse-papiers',
                            copyKeys: 'Appuyez sur <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> pour copier les données du tableau à votre presse-papiers. <br><br>Pour annuler, cliquez sur ce message ou appuyez sur Echap.',
                            copySuccess: {
                                _: '%d lignes copiées',
                                1: '1 ligne copiée'
                            },
                        }
                    },
         ";
         return $options;
    }

    public static function jsResponsibleSelect2JsGrid()
    {
        /**********************************
        *      Custom View Scenario       *
            select2 https://github.com/tabalinas/jsgrid/issues/141
            http://js-grid.com/docs/#custom-field
            http://jsfiddle.net/tabalinas/8thcpey4/
        **********************************/
        
        $script =      "    (function(jsGrid, $, undefined) {
            
                       var NumberField = jsGrid.NumberField;
            
                       function Select2Field(config) {
                       this.items = [];
                       this.selectedIndex = -1;
                       this.valueField = \"\";
                       this.textField = \"\";
                       this.imgField = \"\";
            
                       if (config.valueField && config.items.length)
                           this.valueType = typeof config.items[0][config.valueField];
                       this.sorter = this.valueType;
                       NumberField.call(this, config);
                       }
            
                       Select2Field.prototype = new NumberField({
                       align: \"left\",
                       valueType: \"number\",
            
                       itemTemplate: function(value) {
                           var items = this.items,
                           valueField = this.valueField,
                           textField = this.textField,
                           imgField = this.imgField,
                           resultItem;
            
                           if (valueField) {
                           resultItem = $.grep(items, function(item, index) {
                               return item[valueField] === value;
                           })[0] || {};
                           } else
                           resultItem = items[value];
            
                           var result = (textField ? resultItem[textField] : resultItem);
                           return (result === undefined || result === null) ? \"\" : result;
                       },
            
                       filterTemplate: function() {
                           if (!this.filtering)
                           return \"\";
            
                           var grid = this._grid,
                           _result = this.filterControl = this._createSelect();
                           this._applySelect(_result, this);
            
                           if (this.autosearch) {
                           _result.on(\"change\", function(e) {
                               grid.search();
                           });
                           }
            
                           return _result;
                       },
            
                       insertTemplate: function() {
                           if (!this.inserting)
                           return \"\";
            
                           var _result = this.insertControl = this._createSelect();
                           this._applySelect(_result, this);
                           return _result;
                       },
            
                       editTemplate: function(value) {
                           if (!this.editing)
                           return this.itemTemplate(value);
            
                           var _result = this.editControl = this._createSelect();
                           (value !== undefined) && _result.val(value);
                           this._applySelect(_result, this);
                           return _result;
                       },
            
                       filterValue: function() {
                           var val = this.filterControl.val();
                           return this.valueType === \"number\" ? parseInt(val || 0, 10) : val;
                       },
            
                       insertValue: function() {
                           var val = this.insertControl.val();
                           return this.valueType === \"number\" ? parseInt(val || 0, 10) : val;
                       },
            
                       editValue: function() {
                           var val = this.editControl.val();
                           return this.valueType === \"number\" ? parseInt(val || 0, 10) : val;
                       },
            
                       _applySelect: function(item, self) {
                           setTimeout(function() {
                           var selectSiteIcon = function(opt) {
                               var img = '';
                               try {
                               img = opt.element.attributes.img.value;
                               } catch (e) {}
                               if (!opt.id || !img)
                               return opt.text;
                               var res = $('<span><img src=\"' + img + '\" class=\"img-flag\"/> ' + opt.text + '</span>');
                               return res;
                           }
                           item.select2({
                               // width: self.width,
                               templateResult: selectSiteIcon,
                               templateSelection: selectSiteIcon
                           });
                           });
                       },
            
                       _createSelect: function() {
                           var _result = $(\"<select>\"),
                           valueField = this.valueField,
                           textField = this.textField,
                           imgField = this.imgField,
                           selectedIndex = this.selectedIndex;
            
                           $.each(this.items, function(index, item) {
                           var value = valueField ? item[valueField] : index,
                               text = textField ? item[textField] : item,
                               img = imgField ? item[imgField] : '';
            
                           var _option = $(\"<option>\")
                               .attr(\"value\", value)
                               .attr(\"img\", img)
                               .text(text)
                               .appendTo(_result);
            
                           _option.prop(\"selectedv\", (selectedIndex === index));
                           });
            
                           return _result;
                       }
                       });
            
                       jsGrid.fields.select2 = jsGrid.Select2Field = Select2Field;
            
                        }(jsGrid, jQuery))";
        echo $script;
    }
}