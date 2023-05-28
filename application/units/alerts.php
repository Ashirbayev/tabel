<?php
	class ALERTS
    {
        function ErrorMin($text)
        {
            return '<div class="alert alert-danger alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            '.$text.'</div>';
        }
        
        function SuccesMin($text)
        {
            return '<div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            '.$text.'</div>';
        }
        
        function WarningMin($text)
        {
            return '<div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            '.$text.'</div>';
        }
        
        function InfoMin($text)
        {
            return '<div class="alert alert-info alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            '.$text.'</div>';
        }
        
        function ScriptAlert($text)
        {
            return "<script>window.alert('$text'); console.log('$text');</script>";
        }
        
    }
?>
