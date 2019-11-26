<!--place-->
<div class="content text-center">
    <?php for ($i = 1; $i < 10; $i++): ?>
        <div style="padding: 12px">
            <strong>
                Ряд № <?=$i?>
            </strong>
            <?php for($j = 1; $j <= 15; $j++): ?>
                <div id="place">
                    <span ><?=$j?></span>
                </div>
            <?php endfor;?>
        </div>
    <?php endfor;?>
</div>