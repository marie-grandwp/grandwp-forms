<?php
echo  '<div class="setting-row"><label>Recaptcha Type </label><select name="recaptcha_type-'.$field->getId().'" class="setting-input"><option value="regular" '.selected('regular',$field->getRecaptchaType(),false).'>Regular</option><option value="hidden" '.selected('hidden',$field->getRecaptchaType(),false).'>Hidden</option></select></div>';
