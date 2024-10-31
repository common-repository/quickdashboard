<div class="uk-flex">

  <!-- Left Sitebar Start -->
  <div class="uk-card uk-card-default uk-card-body uk-card-small uk-width-large">
    <!-- Left Sitebar SUBNAVI start -->
    <ul class="uk-subnav uk-subnav-pill uk-flex" uk-switcher="animation: uk-animation-fade">
      <li class="uk-margin-remove uk-active"><a href="#" uk-tooltip="title:<?php _e( "Choose a new WordPress user for whom you want to provide the Quickdashboard.", "quickdashboard" );?>; pos: top-left" class="submodnav" ><?php _e( "New", "quickdashboard" ); ?></a></li>
      <li class="uk-margin-remove"><a href="#" uk-tooltip="title:<?php _e( "Remove, modify or delete assigned WordPress modules for a user.", "quickdashboard" );?>; pos: top-left" class="submodnav" ><?php _e( "Edit", "quickdashboard" ); ?></a></li>
      <li class="uk-margin-remove uk-disabled"><a uk-tooltip="title:<?php _e( "Duplicate a configuration from one configured user to another.", "quickdashboard" );?>; pos: top-left" class="submodnav" ><?php _e( "Duplicate", "quickdashboard" ); ?><br><span style="color:red;font-size:10px;float:right">PRO only</span></a></li>
    </ul>
    <hr>
    <!-- Left Sitebar SUBNAVI end -->
    <!-- Left Sitebar TABS Start -->
    <ul class="uk-switcher uk-margin">

      <!-- TAB NEW -->
      <li class="uk-active">
        <span class="uk-text-small uk-text-bolder uk-text-emphasis"><?php _e( "Choose a WordPress user for whom you want to provide the Quickdashboard.", "quickdashboard" ); ?></span>
        <div class="uk-margin-top">
          <ul uk-accordion>
            <li>
              <a class="uk-accordion-title" href="#"><span class="uk-margin-small-right" uk-icon="icon: question; ratio: 1.2"></span><?php _e( "Do you need help with this", "quickdashboard" );?>?</a>
                <div class="uk-accordion-content">
                    <p>
                    <?php _e( "To remove or add individual modules simply check or uncheck the checkboxes in the admin menu", "quickdashboard" ); ?>.<br><br>
                    <?php _e( "There are a few limitations", "quickdashboard" );?>:<br>
                    - <?php _e( "You cannot select the superadmin and yourself", "quickdashboard" );?>.<br>
                      &nbsp;&nbsp;<?php _e( "(Yourself would immediately be locked out of this page)", "quickdashboard" );?><br>
                    - <?php _e( "This setting page cannot be assigned", "quickdashboard" );?>.
                    </p>
                    <p>
                    <?php _e( "Notice", "quickdashboard" );?>:<br>
                    <?php _e( "Give the user to whom you assign modules the role Administrator", "quickdashboard" );?>.<br>
                    <?php _e( "The rights to work with the WP modules are organised by Quickdashboard", "quickdashboard" );?>.
                    </p>
                </div>
            </li>
          </ul>
        </div>
        <hr>

        <select class="uk-select" name="quickuser" form="dashform" autocomplete="off">
          <option value=''><?php _e( "Please choose a user...", "quickdashboard" );?></option>
          <?php echo quickboardpro_get_user( $dashusers, $dashadmin, 0 ); ?>
        </select>
        <!-- NEW BUTTON start-->
        <div class="saveinfo uk-flex uk-width-1-1 uk-card-small uk-flex-bottom uk-flex-column uk-margin-top">
          <div class="uk-flex uk-width-1-1 uk-margin-small-bottom">
            <input type="submit" name="dashsubmit" class="uk-input uk-button uk-button-primary" value="<?php _e( "Save", "quickdashboard" ); ?>" form="dashform">
          </div>
          <div class="uk-flex uk-width-1-1">
            <button type="button" class="quickabort uk-button uk-button-secondary uk-width-1-1" id="bwidth"><?php _e( "Abort", "quickdashboard" ); ?></button>
          </div>
        </div>
        <!-- NEW BUTTON end -->
      </li>

      <!-- TAB EDIT -->
      <li>
        <span class="uk-text-small uk-text-bolder uk-text-emphasis"><?php _e( "Remove, modify or delete assigned WordPress modules for a user.", "quickdashboard" ); ?></span>
        <div class="uk-margin-top">
          <ul uk-accordion>
            <li>
              <a class="uk-accordion-title" href="#"><span class="uk-margin-small-right" uk-icon="icon: question; ratio: 1.2"></span><?php _e( "Do you need help with this", "quickdashboard" );?>?</a>
                <div class="uk-accordion-content">
                    <p>
                    <?php _e( "To remove or add individual modules simply check or uncheck the checkboxes in the admin menu", "quickdashboard" ); ?>.<br>
                    <?php _e( "To delete all assigned modules simply use the Delete button ", "quickdashboard" ); ?>.
                    </p>
                </div>
            </li>
          </ul>
        </div>
        <hr>
        <select class="uk-select uk-margin-bottom" name="editquickuser" form="dashform" autocomplete="off">
          <option value=''><?php _e( "Please choose a user...", "quickdashboard" );?></option>
          <?php echo quickboardpro_get_user( $dashusers, $dashadmin, 1 ); ?>
        </select>
        <div class="editinfo uk-flex uk-width-1-1 uk-card-small uk-flex-bottom uk-flex-column">
          <div class="uk-flex uk-width-1-1 uk-margin-small-bottom">
            <input type="submit" name="quickuserdelete" class="uk-input uk-button uk-button-danger" value="<?php _e( "Remove usersettings", "quickdashboard" ); ?>" form="dashform">
          </div>
          <div class="uk-flex uk-width-1-1 uk-margin-small-bottom">
            <input type="submit" name="quickuseredit" class="uk-input uk-button uk-button-primary" value="<?php _e( "Save changes", "quickdashboard" ); ?>" form="dashform">
          </div>
          <div class="uk-flex uk-width-1-1">
            <button type="button" class="quickabort uk-button uk-button-secondary uk-width-1-1" id="bwidth"><?php _e( "Abort", "quickdashboard" ); ?></button>
          </div>
        </div>
      </li>
      <!-- TAB EDIT Ende -->
      <!-- TAB DUBLICATE -->
      <li>
        <!-- DUBLICATE BUTTON end -->
      </li>
    </ul>
    <!-- Left Sitebar TABS End -->
  </div>
  <!-- Left Sitebar end -->

  <!-- Right Sitebar start -->
  <!-- Dashboard Preview Start -->
  <div class="uk-padding-remove uk-flex-auto uk-background-muted">
    <div class="quickvorschauwrap">
      <div class="quickinfo"></div>
      <div class="quickvorschau" id="quicksort"></div>
    </div>
  </div>
  <!-- Dashboard Preview End -->
  <!-- Right Sitebar End -->
</div>
