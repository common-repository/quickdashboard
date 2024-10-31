

<h1 style="font-size:34px">
	<img src="<?php echo plugins_url( '/img/qanvalogo.svg', __FILE__ ); ?>" style="width:40px;margin:4px  15px 0 10px;float:left">
	QUICKDASHBOARD
</h1>
<div id="quickprotabs" class="quick">
		
				<br>
	<ul uk-tab class="uk-tab uk-margin-small-bottom">
		<li>
			<a href="#" title="<?php _e( "Select to set or edit", "quickdashboard" ); ?>"><span class="uk-margin-small-right" uk-icon="grid"></span>
			<?php _e( "Modules", "quickdashboard" ); ?></a>
		</li>
		<li class="uk-disabled">
			<a title="<?php _e( "Design module buttons", "quickdashboard" ); ?>" id="buttondesigntab" ><span class="uk-margin-small-right" uk-icon="paint-bucket"></span><?php _e( "Design", "quickdashboard" ); ?><br><span style="color:red;font-size:10px;float:right">PRO only</span></a>
		</li>
		<li>
		<a href="#" title="<?php _e( "Info about the PRO version", "quickdashboard" ); ?>"><span class="uk-margin-small-right" uk-icon="info"></span>
			<?php _e( "PROVERSION", "quickdashboard" ); ?></a>
		</li>
	</ul>
	<ul class="uk-switcher uk-margin xx"> 
		<li><?php include_once 'html/user.html.php'; ?></li>
		<li></li>
		<li><?php include_once 'html/info.html.php'; ?></li>
	</ul>

   <div class="quickboard-spin-container">
				<div class="quickboard-spinner">
				<div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
				</div>
			</div>

</div>
<div class="uk-text-right uk-text-meta uk-text-small"><small>&copy; <?php echo date( "Y");?> <a href="https://qanva.tech" target="_blank" class="uk-link-text" >QANVA.TECH</a> All rights reserved.</small></div>
<style>#wpwrap{background:none !important;background-color:transparent}</style>
