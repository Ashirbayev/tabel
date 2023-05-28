<?php
class FORMS
{
    function InputText($col, $label, $name, $id, $placeholder, $class, $value, $readonly = false, $other_params = false){
        $other_text = '';
        $r = '';
        if($other_params !== false){
            foreach($other_params as $k=>$v){
                $other_text .= ' '.$k.'="'.$v.'"';
            }
        }
        if($readonly == true){$r = 'readonly';}
        return '<div class="col-lg-'.$col.'"><label class="font-noraml">'.$label.'</label>
        <input type="text" id="'.$id.'" name="'.$name.'" '.$r.' '.$other_text.' placeholder="'.$placeholder.'" class="'.$class.'" value="'.$value.'" required>
        </div>';
    }
    
    function inputDate($col, $label, $name, $id, $class, $value, $readonly = false, $other_params = false, $required = '')
    {
        $other_text = '';
        $r = '';
        if($other_params !== false){
            foreach($other_params as $k=>$v){
                $other_text .= ' '.$k.'="'.$v.'"';
            }
        }
        
        if($readonly == true){$r = 'readonly';}
        return '<div class="col-lg-'.$col.'">
                            <div class="form-group">
                                <label class="font-noraml">'.$label.'</label>                                    
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input name="'.$name.'" '.$r.' '.$other_text.' id="'.$id.'" type="text" class="'.$class.'" data-mask="99.99.9999" value="'.$value.'" '.$required.'>
                                </div>
                            </div>
                        </div>';
    }
    
    function FormGroup($lw, $ltext, $rw, $rtext)
    {
        if(trim($rtext) !== '')
        {
            return '<div class="form-group">
                            <label class="col-lg-'.$lw.' control-label">'.$ltext.'</label>
                            <div class="col-lg-'.$rw.'">
                                <div class="formForData">
                                    <p class="form-control-static">'.$rtext.'</p>
                                </div>
                            </div>
                        </div>';
        }else{
            return '<div class="form-group">
                            <label class="col-lg-'.$lw.' control-label">'.$ltext.'</label>
                            <div class="col-lg-'.$rw.'">
                                <div class="formForData">
                                    <p class="form-control-static">'."-".'</p>
                                </div>
                            </div>
                        </div>';
        }                
    }
    
    function FormHorizontalEdit($lc, $ic, $label, $name, $value, $help = '', $placeholder, $id, $required)
    {
        $form = '<div class="form-group">
            <label class="col-lg-'.$lc.' control-label">'.$label.'</label>
            <div class="col-lg-'.$ic.'">
                <input id="'.$id.'" type="text" name="'.$name.'" class="form-control '.$name.'" value="'.$value.'" placeholder="'.$placeholder.'" '.$required.'>';
            if($help !== ''){
                $form .= '<span class="help-block m-b-none">'.$help.'</span>';
            }
            $form .= '</div></div>';
        return $form;
    }    
    
    function FormHorizontalRadio($lc, $ic, $checksName,  $checkArray)
    {
        $form = '<div class="form-group">
                <label class="col-lg-'.$lc.' control-label"></label>
                <div class="col-lg-'.$ic.'">';
        foreach($checkArray as $k=>$v){
            $form .= '<div class="i-checks">
                        <label> <input type="radio" id="'.$v['id'].'" name="'.$checksName.'" value="'.$v['value'].'"> <i></i> '.$v['label'].'</label>
                    </div>';
        }
        $form .= '</div></div>';     
        return $form;
    }
    
    function FormHorizontalCheck($lc, $ic, $label, $name, $id, $check = '')
    {        
        $c = '';
        if($check == 'on'){$c = 'checked';}
        if($check == 1){$c = 'checked';}
        $form = '
        <div class="form-group">
            <label class="col-lg-'.$lc.' control-label"></label>
            <div class="col-lg-'.$ic.'">        
                <div class="i-checks">
                    <label> <input type="checkbox" id="'.$id.'" name="'.$name.'" '.$c.'> <i></i> '.$label.'</label>
                </div>
            </div>
        </div>';     
        return $form;
    }
        
    
    function FormHorizontalCheckList($lc, $ic, $checksName,  $checkArray)
    {        
        $form = '<div class="form-group">
            <label class="col-lg-'.$lc.' control-label"></label>
            <div class="col-lg-'.$ic.'">';
        foreach($checkArray as $k=>$v){
            $form .= '<div class="i-checks">
                <label> <input type="checkbox" id="'.$v['id'].'" name="'.$checksName.'" value="'.$v['value'].'"> <i></i> '.$v['label'].'</label>
            </div>';
        }
        $form .= '</div></div>';     
        return $form;
    }
    
    function FormHorizontalSelect($lc, $ic, $label, $name, $options, $other_class = '', $selected_id = '')
    {
        $class = '';
        if($other_class !== 'form-control'){
            $class = 'select2_demo_1 form-control chosen-select';
        }        
        $form = '<div class="form-group">
            <label class="col-lg-'.$lc.' control-label">'.$label.'</label>
            <div class="col-lg-'.$ic.'">
            <select class="'.$class.'" name="'.$name.'">
            <option></option>';
        foreach($options as $k=>$v){
            $s = '';
            if($v['id'] == trim($selected_id)){$s = 'selected';}
            $form .= '<option value="'.$v['id'].'" '.$s.'>'.$v['text'].'</option>';
        }
        $form .= '</select></div></div>';     
        return $form;
    }
    
        
    function formGroup2($lw, $utext, $dtext, $view = true){                                    
        static $actCount = 0;
        if(trim($dtext) != '')
        {
            return '<div class="col-lg-'.$lw.'" title="'.$utext.'">
                        <strong data-toggle="tooltip" data-placement="buttom" title="'.$utext.'">'.$utext.'</strong><br>
                        <div class="formForData">'.$dtext.'</div></div>';
                            
        }else{
            if($view == true){
                return '<div class="col-lg-'.$lw.'" title="'.$utext.'">
                <strong data-toggle="tooltip" data-placement="buttom" title="'.$utext.'">'.$utext.'</strong><br>
                <div class="formForData">'."-".'</div></div>';
            }else{
                return '<div class="col-lg-'.$lw.'" title=""></div>';
            }
        }
    }
    
        /*
        function TableForms($tdarray)
        {
            $text = '<tr class="gradeX">';
            foreach($tdarray as $v){
                $text .= '<td>'.$v.'</td>';
            }
            $text .= '</tr>';
            return $text;
        }
        /*/
    function tableForms($sername, $name, $patronymic, $dateOfBirth, $share, $sik, $rnn, $iin, $address){            
        return '<tr class="gradeX">
            <td>'.$sername.'</td>
                <td>'.$name.'</td>
                <td>'.$patronymic.'</td>
                <td>'.$dateOfBirth.'</td>
                <td>'.$share.'</td>
                <td>'.$sik.'</td>
                <td>'.$rnn.'</td>
                <td>'.$iin.'</td>
                <td>'.$address.'</td>
            </tr>';
    }
        
 
    function formGroupForDate($lw, $utext, $dtext, $etext){                            
         if(trim($dtext) != '')
             {
                return '<div class="col-lg-'.$lw.'">
                                 <strong>'.$utext.'</strong><br>
                                <div class="col-lg-12 formForData">    
                                    <div class="col-lg-4">            
                                            '.$dtext.'
                                    </div>
                                    <div class="col-lg-4">            
                                                по
                                    </div>
                                    <div class="col-lg-4">            
                                            '.$etext.'
                                    </div>
                                </div>
                                </div>';
                }else{
                return  '<div class="col-lg-'.$lw.'">
                                 <strong>'.$utext.'</strong><br>
                                <div class="col-lg-12 formForData">    
                                    <div class="col-lg-4">            
                                            '."-".'
                                    </div>
                                    <div class="col-lg-4">            
                                                по
                                    </div>
                                    <div class="col-lg-4">            
                                            '."-".'
                                    </div>
                                </div>
                                </div>';
            }
        }
        
        function ContractsMenu($size, $cnct, $paym_code){
            return '
            <div class="col-lg-'.$size.'" >
                <strong data-toggle="tooltip" data-placement="buttom" title="Меню">Меню</strong>
                <div class="btn-group" style="width: 100%;">
                    <button data-toggle="dropdown" class="btn btn-white" aria-expanded="false" style="width: 100%;border-radius: 5px;color: #FFF;background: #848688;border: 1px solid #CECECE;padding: 1px 6px;">
                    Выбор функции <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="#">Печать договора</a></li>
                        <li><a href="rep?id=2003&'.$cnct.'" target="_blank">Заявка на андерайтинг</a></li>
                        <li class="divider"></li>
                        <li><a href="new_contract?CNCT_ID='.$cnct.'&&paym_code='.$paym_code.'">Редактирование</a></li>
                        <li><a href="#">Регистрация дополнительного соглашения</a></li>
                        <li><a href="#">Перенести в архив</a></li>
                        <li class="divider"></li>
                        <li><a href="#" data-toggle="modal" data-target="#myModal2" >Служебные записки</a></li>                
                        <li><a href="#">Просмотр и добавление документов страхового дела</a></li>
                        <li><a href="#">Просмотр и добавление отсканированных документов страхового дела</a></li>            
                    </ul>
                </div>
            </div>';
        }
        
        function ModalContainer($id, $title, $head_text, $html, $sav_js_function, $icheck = '')
        {
            $form = '
            <div class="modal inmodal fade" id="'.$id.'" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">'.$title.'</h4>
                            <small class="font-bold">'.$head_text.'</small>
                        </div>
                        <div class="modal-body">'.$html.'</div>
                        <div class="modal-footer">';
                        
                        if($icheck !== ''){
                            $form .= '<span class="pull-left">'.$icheck.'</span>';
                        }
                        $form .='            
                            <button type="button" class="btn btn-primary" onclick="'.$sav_js_function.'">Сохранить</button>
                            <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>                
                        </div>
                    </div>
                </div>
            </div>';
            
            return $form;
        }
    }
?>