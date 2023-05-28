<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo $title; ?></h2>
        <ol class="breadcrumb">
            <li><a href="/">Главная</a></li>
            <?php
                foreach($breadwin as $b){echo "<li>$b</li>";}
            ?>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="row">
    <div class="col-lg-12"><?php echo $msg; ?></div>
</div>
