<div class="main-menu menu-fixed menu-light bg-warning menu-accordion  menu-shadow" data-scroll-to-active="true" class="ps-scrollbar-y-rail">
    <div class="main-menu-content">
		<ul class="navigation navigation-main bg-warning" id="main-menu-navigation" data-menu="menu-navigation">
			<?php
				$menus = require "menu.php";
				foreach($menus as $menu){?>
					<li class=" nav-item">
						<a href=" <?= $menu['full_url']; ?> ">
							<i class="<?= $menu['icon']; ?>"></i>
							<span class="menu-title" data-i18n=""> <?= $menu['title']; ?> </span>
						</a>
						<?php
							if($menu['hasChildren']){ 
								$menu_items = $menu['children'];
								$i=0;
								?><ul class="menu-content"><?php 	
								foreach($menu_items as $menu_item){
								//var_dump($menu_item);
									if($menu_item['alwaysVisible'] || (!$menu_item['alwaysVisible'] && $menu_item['action'] == ($route??'none')) ){
									?>
									<li <?= ($menu_item['action'] == ($route??'none'))? 'class="active"':''; ?>>
										<a class="menu-item" href="<?= $menu_item['full_url']; ?>" title="<?= $menu_item['title']; ?>" data-i18n="nav.starter_kit.<?= ++$i; ?>_columns"><?= $menu_item['title']; ?></a>
									</li>
								<?php 	}
									}
								?>
								</ul>
							<?php } ?>
					</li>
			<?php } ?>
		</ul>
	</div>
</div>

