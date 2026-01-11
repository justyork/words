<?php
/* @var $this yii\web\View */
$back = $this->params['back_link'];
?>
<div class="ui borderless main icon menu modern-header" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%) !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important; position: sticky; top: 0; z-index: 1000; border: none !important; margin: 0 !important;">
    <div class="ui container" style="max-width: 1200px; display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1rem;">

        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <?php if ($back): ?>
                <a href="<?= $back ?>" class="item" style="color: white; padding: 0.75rem; display: flex; align-items: center; justify-content: center; min-width: 44px; min-height: 44px; border-radius: var(--radius-md); transition: var(--transition);" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='transparent'">
                    <i class="arrow left icon"></i>
                </a>
            <?php endif; ?>
            <a href="#" class="item" id="left-sb-btn" style="color: white; padding: 0.75rem; display: flex; align-items: center; justify-content: center; min-width: 44px; min-height: 44px; border-radius: var(--radius-md); transition: var(--transition);" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='transparent'">
                <i class="bars icon"></i>
            </a>
        </div>
        
        <div class="header center item" style="color: white; font-weight: 700; font-size: 1.125rem; flex: 1; text-align: center; padding: 0 0.5rem;">
            <a href="<?= yii\helpers\Url::to(['site/index']) ?>" style="color: white; text-decoration: none; display: block;">LWords</a>
        </div>

        <div style="display: flex; align-items: center;">
            <?php if (!empty($this->params['sidebar']) && is_array($this->params['sidebar'])): ?>
            <a href="#" class="item right floated" id="right-sb-btn" style="color: white; padding: 0.75rem; display: flex; align-items: center; justify-content: center; min-width: 44px; min-height: 44px; border-radius: var(--radius-md); transition: var(--transition);" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='transparent'">
                <i class="cog icon"></i>
            </a>
            <?php else: ?>
                <div style="width: 44px;"></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
@media (max-width: 767px) {
    .modern-header .ui.container {
        position: relative;
        padding: 0.75rem 1rem !important;
    }
    
    .modern-header .header.center.item {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        flex: 0 0 auto !important;
        width: auto !important;
        padding: 0 !important;
        font-size: 1rem !important;
        white-space: nowrap;
    }
    
    .modern-header .header.center.item a {
        display: inline-block !important;
    }
}

@media (min-width: 768px) {
    .modern-header .ui.container {
        padding: 1rem 1.5rem;
    }
    
    .modern-header .header.center.item {
        font-size: 1.25rem;
    }
}
</style>
