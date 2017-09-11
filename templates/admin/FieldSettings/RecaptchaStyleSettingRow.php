<?php
echo  '<div class="setting-row"><label>Recaptcha Style </label><select name="recaptcha_style-'.$field->getId().'" class="setting-input"><option value="light" '.selected('light',$field->getRecaptchaStyle(),false).'>Light</option><option value="dark" '.selected('dark',$field->getRecaptchaStyle(),false).'>Dark</option></select></div>';
