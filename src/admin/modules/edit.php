<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-11-2010 0:44
 */

if (!defined('NV_IS_FILE_MODULES')) {
    die('Stop!!!');
}

$data = [];
$data['error'] = '';
$mod = $nv_Request->get_title('mod', 'get');

if (empty($mod) or !preg_match($global_config['check_module'], $mod)) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

$sth = $db->prepare('SELECT * FROM ' . NV_MODULES_TABLE . ' WHERE title= :title');
$sth->bindParam(':title', $mod, PDO::PARAM_STR);
$sth->execute();
$row = $sth->fetch();
if (empty($row)) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

$theme_site_array = $theme_mobile_array = [];
$theme_array = scandir(NV_ROOTDIR . '/themes');

$theme_mobile_default = [];
$theme_mobile_default[''] = array(
    'key' => '',
    'title' => $nv_Lang->getModule('theme_mobiledefault')
);
$theme_mobile_default[':pcsite'] = array(
    'key' => ':pcsite',
    'title' => $nv_Lang->getModule('theme_mobile_bysite')
);
$theme_mobile_default[':pcmod'] = array(
    'key' => ':pcmod',
    'title' => $nv_Lang->getModule('theme_mobile_bymod')
);

foreach ($theme_array as $dir) {
    if (preg_match($global_config['check_theme'], $dir)) {
        if (file_exists(NV_ROOTDIR . '/themes/' . $dir . '/config.ini')) {
            $theme_site_array[] = $dir;
        }
    } elseif (preg_match($global_config['check_theme_mobile'], $dir)) {
        if (file_exists(NV_ROOTDIR . '/themes/' . $dir . '/config.ini')) {
            $theme_mobile_array[] = $dir;
        }
    }
}

$theme_list = $theme_mobile_list = $array_theme = [];

// Chi nhung giao dien da duoc thiet lap layout moi duoc them
$result = $db->query('SELECT DISTINCT theme FROM ' . NV_PREFIXLANG . '_modthemes WHERE func_id=0');
while (list($theme) = $result->fetch(3)) {
    if (in_array($theme, $theme_site_array)) {
        $array_theme[] = $theme;
        $theme_list[] = $theme;
    } elseif (in_array($theme, $theme_mobile_array)) {
        $array_theme[] = $theme;
        $theme_mobile_list[] = $theme;
    }
}

$groups_list = nv_groups_list();

if ($nv_Request->get_int('save', 'post') == '1') {
    $custom_title = $nv_Request->get_title('custom_title', 'post', '', 1);
    $site_title = $nv_Request->get_title('site_title', 'post', '');
    $admin_title = $nv_Request->get_title('admin_title', 'post', '', 1);
    $theme = $nv_Request->get_title('theme', 'post', '', 1);
    $module_theme = $nv_Request->get_title('module_theme', 'post', '', 1);
    $mobile = $nv_Request->get_title('mobile', 'post', '', 0);
    $description = $nv_Request->get_title('description', 'post', '', 1);
    $description = nv_substr($description, 0, 255);
    $keywords = $nv_Request->get_title('keywords', 'post', '', 1);
    $act = $nv_Request->get_int('act', 'post', 0);
    $rss = $nv_Request->get_int('rss', 'post', 0);
    $sitemap = $nv_Request->get_int('sitemap', 'post', 0);

    if (!empty($theme) and !in_array($theme, $theme_list)) {
        $theme = '';
    }

    if (!empty($mobile) and !in_array($mobile, $theme_mobile_list) and !isset($theme_mobile_default[$mobile])) {
        $mobile = '';
    }

    if (!empty($keywords)) {
        $keywords = explode(',', $keywords);
        $keywords = array_map('trim', $keywords);
        $keywords = implode(', ', $keywords);
    }

    if ($mod != $global_config['site_home_module']) {
        $groups_view = $nv_Request->get_array('groups_view', 'post', []);
        $groups_view = !empty($groups_view) ? implode(',', nv_groups_post(array_intersect($groups_view, array_keys($groups_list)))) : '';
    } else {
        $act = 1;
        $groups_view = '6';
    }

    if ($custom_title != '') {
        $array_layoutdefault = [];

        foreach ($array_theme as $_theme) {
            $xml = simplexml_load_file(NV_ROOTDIR . '/themes/' . $_theme . '/config.ini');
            $layoutdefault = ( string )$xml->layoutdefault;

            if (!empty($layoutdefault) and file_exists(NV_ROOTDIR . '/themes/' . $_theme . '/layout/layout.' . $layoutdefault . '.tpl')) {
                $array_layoutdefault[$_theme] = $layoutdefault;
            } else {
                $data['error'][] = $_theme;
            }
        }

        if (empty($data['error'])) {
            foreach ($array_layoutdefault as $selectthemes => $layoutdefault) {
                $array_func_id = [];
                $sth = $db->prepare('SELECT func_id FROM ' . NV_PREFIXLANG . '_modthemes WHERE theme= :theme');
                $sth->bindParam(':theme', $selectthemes, PDO::PARAM_STR);
                $sth->execute();
                while (list($func_id) = $sth->fetch(3)) {
                    $array_func_id[] = $func_id;
                }

                $sth = $db->prepare('SELECT func_id FROM ' . NV_MODFUNCS_TABLE . ' WHERE in_module= :in_module AND show_func=1 ORDER BY subweight ASC');
                $sth->bindParam(':in_module', $mod, PDO::PARAM_STR);
                $sth->execute();
                while (list($func_id) = $sth->fetch(3)) {
                    if (!in_array($func_id, $array_func_id)) {
                        $sth2 = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_modthemes (func_id, layout, theme) VALUES (' . $func_id . ', :layout, :theme)');
                        $sth2->bindParam(':layout', $layoutdefault, PDO::PARAM_STR);
                        $sth2->bindParam(':theme', $selectthemes, PDO::PARAM_STR);
                        $sth2->execute();
                    }
                }
            }

            // Check module_theme
            $_theme_check = (!empty($theme)) ? $theme : $global_config['site_theme'];
            if (!empty($_theme_check) and file_exists(NV_ROOTDIR . '/themes/' . $_theme_check . '/theme.php')) {
                if (!file_exists(NV_ROOTDIR . '/themes/' . $_theme_check . '/modules/' . $module_theme)) {
                    $module_theme = $row['module_file'];
                }
            } else {
                $module_theme = $row['module_file'];
            }

            $sth = $db->prepare('UPDATE ' . NV_MODULES_TABLE . ' SET
                module_theme=:module_theme, custom_title=:custom_title, site_title=:site_title, admin_title=:admin_title, theme= :theme, mobile= :mobile, description= :description,
                keywords= :keywords, groups_view= :groups_view, act=' . $act . ', rss=' . $rss . ', sitemap=' . $sitemap . '
            WHERE title= :title');
            $sth->bindParam(':module_theme', $module_theme, PDO::PARAM_STR);
            $sth->bindParam(':custom_title', $custom_title, PDO::PARAM_STR);
            $sth->bindParam(':site_title', $site_title, PDO::PARAM_STR);
            $sth->bindParam(':admin_title', $admin_title, PDO::PARAM_STR);
            $sth->bindParam(':theme', $theme, PDO::PARAM_STR);
            $sth->bindParam(':mobile', $mobile, PDO::PARAM_STR);
            $sth->bindParam(':description', $description, PDO::PARAM_STR);
            $sth->bindParam(':keywords', $keywords, PDO::PARAM_STR);
            $sth->bindParam(':groups_view', $groups_view, PDO::PARAM_STR);
            $sth->bindParam(':title', $mod, PDO::PARAM_STR);
            $sth->execute();

            $mod_name = change_alias($nv_Request->get_title('mod_name', 'post'));
            if ($mod_name != $mod and preg_match($global_config['check_module'], $mod_name)) {
                $module_version = [];
                $version_file = NV_ROOTDIR . '/modules/' . $row['module_file'] . '/version.php';
                if (file_exists($version_file)) {
                    include $version_file;
                    if (isset($module_version['virtual']) and $module_version['virtual']) {
                        $sth = $db->prepare('UPDATE ' . NV_MODULES_TABLE . ' SET title= :mod_name WHERE title= :mod_old');
                        $sth->bindParam(':mod_name', $mod_name, PDO::PARAM_STR);
                        $sth->bindParam(':mod_old', $mod, PDO::PARAM_STR);
                        if ($sth->execute()) {
                            // Change module name
                            $sth = $db->prepare('UPDATE ' . NV_MODFUNCS_TABLE . ' SET in_module= :mod_name WHERE in_module= :mod_old');
                            $sth->bindParam(':mod_name', $mod_name, PDO::PARAM_STR);
                            $sth->bindParam(':mod_old', $mod, PDO::PARAM_STR);
                            $sth->execute();

                            // Change site_home_module
                            if ($mod == $global_config['site_home_module']) {
                                $sth = $db->prepare("UPDATE " . NV_CONFIG_GLOBALTABLE . " SET config_value= :config_value WHERE config_name = 'site_home_module' AND lang = '" . NV_LANG_DATA . "' AND module='global'");
                                $sth->bindParam(':config_value', $mod_name, PDO::PARAM_STR);
                                $sth->execute();
                            }

                            // Change block
                            $sth = $db->prepare('UPDATE ' . NV_BLOCKS_TABLE . '_groups SET module= :mod_name WHERE module= :mod_old');
                            $sth->bindParam(':mod_name', $mod_name, PDO::PARAM_STR);
                            $sth->bindParam(':mod_old', $mod, PDO::PARAM_STR);
                            $sth->execute();

                            // Change config
                            $sth = $db->prepare("UPDATE " . NV_CONFIG_GLOBALTABLE . " SET module= :mod_name WHERE lang = '" . NV_LANG_DATA . "' AND module= :mod_old");
                            $sth->bindParam(':mod_name', $mod_name, PDO::PARAM_STR);
                            $sth->bindParam(':mod_old', $mod, PDO::PARAM_STR);
                            $sth->execute();

                            // Change comment
                            $sth = $db->prepare("UPDATE " . NV_PREFIXLANG . "_comment SET module= :mod_name WHERE module= :mod_old");
                            $sth->bindParam(':mod_name', $mod_name, PDO::PARAM_STR);
                            $sth->bindParam(':mod_old', $mod, PDO::PARAM_STR);
                            $sth->execute();

                            // Change logs
                            $sth = $db->prepare("UPDATE " . $db_config['prefix'] . "_logs SET module_name= :mod_name WHERE lang = '" . NV_LANG_DATA . "' AND module_name= :mod_old");
                            $sth->bindParam(':mod_name', $mod_name, PDO::PARAM_STR);
                            $sth->bindParam(':mod_old', $mod, PDO::PARAM_STR);
                            $sth->execute();
                        }
                    }
                }
            }
            $nv_Cache->delAll();
            nv_insert_logs(NV_LANG_DATA, $module_name, sprintf($nv_Lang->getModule('edit'), $mod), '', $admin_info['userid']);

            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
        } else {
            $data['error'] = sprintf($nv_Lang->getModule('edit_error_update_theme'), implode(', ', $data['error']));
        }
    } elseif ($groups_view != '') {
        $row['groups_view'] = $groups_view;
    }
} else {
    $custom_title = $row['custom_title'];
    $site_title = $row['site_title'];
    $admin_title = $row['admin_title'];
    $theme = $row['theme'];
    $module_theme = $row['module_theme'];
    $mobile = $row['mobile'];
    $act = $row['act'];
    $description = $row['description'];
    $keywords = $row['keywords'];
    $rss = $row['rss'];
    $sitemap = $row['sitemap'];
}

$groups_view = explode(',', $row['groups_view']);

if (empty($custom_title)) {
    $custom_title = $mod;
}

$page_title = sprintf($nv_Lang->getModule('edit'), $mod);

if (file_exists(NV_ROOTDIR . '/modules/' . $row['module_file'] . '/funcs/rss.php')) {
    $data['rss'] = $rss;
}
$sitemaps = nv_scandir(NV_ROOTDIR . '/modules/' . $row['module_file'] . '/funcs', '/^sitemap(.*?)\.php$/');
if (sizeof($sitemaps)) {
    $data['sitemap'] = $sitemap;
}

$data['custom_title'] = $custom_title;
$data['site_title'] = $site_title;
$data['admin_title'] = $admin_title;
$data['theme'] = $theme;
$data['mobile'] = $mobile;
$data['description'] = $description;
$data['keywords'] = $keywords;
$data['mod_name'] = $mod;
$data['module_theme'] = $module_theme;
$data['act'] = $act;
$data['groups_view'] = $groups_view;

$tpl = new \NukeViet\Template\Smarty();
$tpl->setTemplateDir(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$tpl->assign('LANG', $nv_Lang);
$tpl->assign('FORM_ACTION', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=edit&amp;mod=' . $mod);
$tpl->assign('DATA', $data);
$tpl->assign('THEME_LIST', $theme_list);
$tpl->assign('THEME_MOBILE_DEFAULT', $theme_mobile_default);
$tpl->assign('THEME_MOBILE_LIST', $theme_mobile_list);
$tpl->assign('SITE_HOME_MODULE', $global_config['site_home_module']);
$tpl->assign('GROUPS_LIST', $groups_list);
$tpl->assign('ERROR', $data['error']);

$contents = $tpl->fetch('edit.tpl');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
