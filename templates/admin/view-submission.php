<?php
/**
 * Template for view submission page
 */
global $wpdb;

if( !isset( $submission ) ){
    throw new Exception( '"submission" variable is not reachable in view-submission template.' );
}

if( !( $submission instanceof \GDForm\Models\Submission ) ){
    throw new Exception( '"submission" variable must be instance of Submission class.' );
}

$attachments = array();
?>
<div class="wrap " data-form="<?php echo $submission->getId();?>">
    <div class="gdfrm_header">
        <i class="gdicon gdicon-logo"></i>
        <span><?php _e('View Submission',GDFRM_TEXT_DOMAIN);?></span>
        <ul>
            <li>
                <a href="http://grandwp.com/wordpress-contact-form-builder" target="_blank"><?php _e('Go Pro',GDFRM_TEXT_DOMAIN);?></a>
            </li>
            <li>
                <a href="http://grandwp.com/grandwp-forms-user-manual" target="_blank"><?php _e('Help',GDFRM_TEXT_DOMAIN);?></a>
            </li>
        </ul>
    </div>

    <div class="gdfrm_content">

        <div class="gdfrm-submission-leftcol">
            <table>
                <?php
                $submission_fields = $submission->getSubmissionFields();
                foreach ($submission_fields as $submission_field) {
                    $field = $submission_field['Field'];
                    if($field->getType()->getName()=='upload'){
                        $form_attachments[$field->getLabel()]=json_decode($submission_field['Value']);
                    } else if($field->getType()->getName()!=='captcha'){
                        ?>
                        <tr>
                            <td>
                                <i class="gdfrm-<?php echo $field->getType()->getName();?>"></i> <?php echo $field->getLabel();?>
                            </td>

                            <td>
                                <?php if(in_array($field->getType()->getName(),array('address','selectbox','checkbox','imageselect'))){
                                    $rows = json_decode($submission_field['value']);
                                    foreach ($rows as $key=>$row){
                                        if($row == '') $row = '<i class="fa fa-minus"></i>';
                                        if(!is_int($key)){
                                            echo '<b>'.$key.'</b> : '.$row.'<br>';
                                        } else{
                                            echo $row.'<br>';

                                        }
                                    }
                                }
                                else {
                                    echo ($submission_field['Value']=='')?'<i class="fa fa-minus"></i>':$submission_field['Value'];
                                } ?>
                            </td>
                        </tr>
                    <?php } /* endif */
                }/* endforeach */
                ?>
            </table>

            <?php if(!empty($form_attachments)):?>

                <div class="gdfrm-attachments">
                    <h2><?php _e('File Attachments',GDFRM_TEXT_DOMAIN);?></h2>

                    <?php foreach ($form_attachments as $field_label=>$field_attachments){ ?>
                        <div class="gdfrm-field-attachments">
                            <h3><?php echo $field_label;?></h3>

                            <?php foreach ($field_attachments as $attachment): $type = wp_check_filetype($attachment->name); ?>
                                <div class="gdfrm-attachment">
                                    <a href="<?php echo $attachment->url;?>"><i class="gdfrm-<?php  echo $type['ext'];?>"></i> <h4><?php echo $attachment->name;?></h4></a>
                                </div>
                            <?php endforeach;?>
                        </div>
                    <?php } ?>
                </div>
            <?php endif;?>
        </div>

        <div class="gdfrm-submission-rightcol">
            <table>
                <tr>
                    <td>
                        <i class="fa fa-clock-o"></i><b><?php _e('Submission Date',GDFRM_TEXT_DOMAIN);?></b>
                    </td>
                    <td>
                        <?php echo $submission->getDate();?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <i class="fa fa-user-circle"></i><b><?php _e('User',GDFRM_TEXT_DOMAIN);?></b>
                    </td>
                    <td>
                        <?php echo 'guest';?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <i class="fa fa-globe"></i><b><?php _e('Location',GDFRM_TEXT_DOMAIN);?></b>
                    </td>
                    <td>
                        <?php
                        $ip = $submission->getIpAddress();
                        $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));
                        if($ip_data && $ip_data->geoplugin_countryName != null){
                            $country = $ip_data->geoplugin_countryName;
                            $city = $ip_data->geoplugin_city;

                            echo $city.' , '.$country;
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <i class="fa fa-map-marker"></i><b><?php _e('IP Address',GDFRM_TEXT_DOMAIN);?></b>
                    </td>
                    <td>
                        <?php
                        $ip = $submission->getIpAddress();
                        echo $ip;
                        ?>
                    </td>
                </tr>
            </table>
        </div>

    </div>

</div>