    </div>
    
    <!--
    <div class="footer">
        <div class="pull-right">
            10GB of <strong>250GB</strong> Free.
        </div>
        <div>
            <strong>АО "КСЖ "ГАК"</strong> &copy; 2016
        </div>
    </div>
    -->
</div>
    <script src="styles/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="styles/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    
    <script src="styles/js/plugins/pace/pace.min.js"></script>
    <script src="styles/js/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="styles/js/script.js"></script>
    
    <?php 
        echo $msgAlert;        
    ?>
        
    <script src="styles/js/inspinia.js"></script>   
    <script src="styles/js/others/mail.js"></script>
    <script src="styles/js/plugins/sweetalert/sweetalert.min.js"></script>
        
    <?php     
        if(count($js_loader) > 0){
            foreach($js_loader as $js){
                echo "\n";
                echo '<script src="'.$js.'"></script>';
            }
        }    
   
        echo $othersJs;
        echo $othersJs2;
        echo $othersJs3;                
    ?>
    <script>
    if (navigator.appName == 'Microsoft Internet Explorer' ||  !!(navigator.userAgent.match(/Trident/) || navigator.userAgent.match(/rv:11/)) || (typeof $.browser !== "undefined" && $.browser.msie == 1))
    {
      alert("Не рекомендуется использование браузера Internet Explorer в данном портале! Это приведет к техническим ошибкам. Используйте альтернативные браузеры (рекомендуемые: Google Chrome, Mozilla Firefox, Opera, Safari)");
      window.close();
    }
    </script>
    </body>
</html>

