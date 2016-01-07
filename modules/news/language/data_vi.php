<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC.
 * All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-10-2010 20:59
 */

if (!defined('NV_ADMIN')) {
    die('Stop!!!');
}

/**
 * Note:
 * - Module var is: $lang, $module_file, $module_data, $module_upload, $module_theme, $module_name
 * - Accept global var: $db, $db_config, $global_config
 */

if (!function_exists('nv_news_check_image_exit')) {

    /**
     *
     * @param mixed $homeimgfile
     * @param mixed $module_upload
     * @return
     *
     */
    function nv_news_check_image_exit($homeimgfile, $module_upload)
    {
        if (!empty($homeimgfile) and file_exists(NV_UPLOADS_REAL_DIR . '/news/' . $homeimgfile)) {
            $homeimgthumb = 1;
            if ($module_upload != 'news') {
                if (!(nv_copyfile(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/news/' . $homeimgfile, NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $homeimgfile) and nv_copyfile(NV_ROOTDIR . '/' . NV_FILES_DIR . '/news/' . $homeimgfile, NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_upload . '/' . $homeimgfile))) {
                    $homeimgfile = '';
                    $homeimgthumb = 0;
                }
            }
        } else {
            $homeimgfile = '';
            $homeimgthumb = 0;
        }

        return array(
            $homeimgfile,
            $homeimgthumb
        );
    }
}
if (!function_exists('nv_news_get_bodytext')) {

    /**
     *
     * @param mixed $bodytext
     * @return
     *
     */
    function nv_news_get_bodytext($bodytext)
    {
        // Get image tags
        if (preg_match_all("/\<img[^\>]*src=\"([^\"]*)\"[^\>]*\>/is", $bodytext, $match)) {
            foreach ($match[0] as $key => $_m) {
                $textimg = '';
                if (strpos($match[1][$key], 'data:image/png;base64') === false) {
                    $textimg = " " . $match[1][$key];
                }
                if (preg_match_all("/\<img[^\>]*alt=\"([^\"]+)\"[^\>]*\>/is", $_m, $m_alt)) {
                    $textimg .= " " . $m_alt[1][0];
                }
                $bodytext = str_replace($_m, $textimg, $bodytext);
            }
        }
        // Get link tags
        if (preg_match_all("/\<a[^\>]*href=\"([^\"]+)\"[^\>]*\>(.*)\<\/a\>/isU", $bodytext, $match)) {
            foreach ($match[0] as $key => $_m) {
                $bodytext = str_replace($_m, $match[1][$key] . " " . $match[2][$key], $bodytext);
            }
        }

        $bodytext = str_replace('&nbsp;', ' ', strip_tags($bodytext));
        return preg_replace('/[ ]+/', ' ', $bodytext);
    }
}

// News: cat
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat (catid, parentid, title, titlesite, alias, description, descriptionhtml, image, viewdescription, weight, sort, lev, viewcat, numsubcat, subcatid, inhome, numlinks, newday, keywords, admins, add_time, edit_time, groups_view) VALUES (1, 0, 'Tin tức', '', 'Tin-tuc', '', '', '', 0, 1, 1, 0, 'viewcat_main_right', 3, '8,12,9', 1, 4, '2', '', '', 1274986690, 1274986690, '6')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat (catid, parentid, title, titlesite, alias, description, descriptionhtml, image, viewdescription, weight, sort, lev, viewcat, numsubcat, subcatid, inhome, numlinks, newday, keywords, admins, add_time, edit_time, groups_view) VALUES (2, 0, 'Sản phẩm', '', 'San-pham', '', '', '', 0, 2, 5, 0, 'viewcat_page_new', 0, '', 1, 4, '2', '', '', 1274986705, 1274986705, '6')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat (catid, parentid, title, titlesite, alias, description, descriptionhtml, image, viewdescription, weight, sort, lev, viewcat, numsubcat, subcatid, inhome, numlinks, newday, keywords, admins, add_time, edit_time, groups_view) VALUES (8, 1, 'Thông cáo báo chí', '', 'thong-cao-bao-chi', '', '', '', 0, 1, 2, 1, 'viewcat_page_new', 0, '', 1, 4, '2', '', '', 1274987105, 1274987244, '6')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat (catid, parentid, title, titlesite, alias, description, descriptionhtml, image, viewdescription, weight, sort, lev, viewcat, numsubcat, subcatid, inhome, numlinks, newday, keywords, admins, add_time, edit_time, groups_view) VALUES (9, 1, 'Tin công nghệ', '', 'Tin-cong-nghe', '', '', '', 0, 3, 4, 1, 'viewcat_page_new', 0, '', 1, 4, '2', '', '', 1274987212, 1274987212, '6')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat (catid, parentid, title, titlesite, alias, description, descriptionhtml, image, viewdescription, weight, sort, lev, viewcat, numsubcat, subcatid, inhome, numlinks, newday, keywords, admins, add_time, edit_time, groups_view) VALUES (10, 0, 'Đối tác', '', 'Doi-tac', '', '', '', 0, 3, 9, 0, 'viewcat_main_right', 0, '', 1, 4, '2', '', '', 1274987460, 1274987460, '6')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat (catid, parentid, title, titlesite, alias, description, descriptionhtml, image, viewdescription, weight, sort, lev, viewcat, numsubcat, subcatid, inhome, numlinks, newday, keywords, admins, add_time, edit_time, groups_view) VALUES (11, 0, 'Tuyển dụng', '', 'Tuyen-dung', '', '', '', 0, 4, 12, 0, 'viewcat_page_new', 0, '', 1, 4, '2', '', '', 1274987538, 1274987538, '6')");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat (catid, parentid, title, titlesite, alias, description, descriptionhtml, image, viewdescription, weight, sort, lev, viewcat, numsubcat, subcatid, inhome, numlinks, newday, keywords, admins, add_time, edit_time, groups_view) VALUES (12, 1, 'Bản tin nội bộ', '', 'Ban-tin-noi-bo', '', '', '', 0, 2, 3, 1, 'viewcat_page_new', 0, '', 1, 4, '2', '', '', 1274987902, 1274987902, '6')");

// News: rows
list ($homeimgfile, $homeimgthumb) = nv_news_check_image_exit('nangly.jpg', $module_upload);
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows VALUES (1, 1, '1,8,12', 0, 1, 'Quỳnh Nhi', 1, 1274989177, 1275318126, 1, 1274989140, 0, 2, 'Ra mắt công ty mã nguồn mở đầu tiên tại Việt Nam', 'Ra-mat-cong-ty-ma-nguon-mo-dau-tien-tai-Viet-Nam', 'Mã nguồn mở NukeViet vốn đã quá quen thuộc với cộng đồng CNTT Việt Nam trong mấy năm qua. Tuy chưa hoạt động chính thức, nhưng chỉ trong khoảng 5 năm gần đây, mã nguồn mở NukeViet đã được dùng phổ biến ở Việt Nam, áp dụng ở hầu hết các lĩnh vực, từ tin tức đến thương mại điện tử, từ các website cá nhân cho tới những hệ thống website doanh nghiệp.', " . $db->quote($homeimgfile) . ", 'Thành lập VINADES.,JSC', " . intval($homeimgthumb) . ", 1, '6', 1, 2, 0, 0, 0)");

list ($homeimgfile, $homeimgthumb) = nv_news_check_image_exit('chuc-mung-nukeviet-thong-tu-20-bo-tttt.jpg', $module_upload);
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows VALUES (11, 1, '1', 0, 1, '', 4, 1445309676, 1445309676, 1, 1445309520, 0, 2, 'NukeViet được ưu tiên mua sắm, sử dụng trong cơ quan, tổ chức nhà nước', 'nukeviet-duoc-uu-tien-mua-sam-su-dung-trong-co-quan-to-chuc-nha-nuoc', 'Ngày 5/12/2014, Bộ trưởng Bộ TT&TT Nguyễn Bắc Son đã ký ban hành Thông tư 20/2014/TT-BTTTT (Thông tư 20) quy định về các sản phẩm phần mềm nguồn mở (PMNM) được ưu tiên mua sắm, sử dụng trong cơ quan, tổ chức nhà nước. NukeViet (phiên bản 3.4.02 trở lên) là phần mềm được nằm trong danh sách này.', " . $db->quote($homeimgfile) . ", 'NukeViet được ưu tiên mua sắm, sử dụng trong cơ quan, tổ chức nhà nước', " . intval($homeimgthumb) . ", 1, '4', 1, 2, 0, 0, 0)");

list ($homeimgfile, $homeimgthumb) = nv_news_check_image_exit('', $module_upload);
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows VALUES (12, 11, '11', 0, 1, '', 0, 1445391061, 1445394203, 1, 1445391000, 0, 2, 'Công ty VINADES tuyển dụng nhân viên kinh doanh', 'cong-ty-vinades-tuyen-dung-nhan-vien-kinh-doanh', 'Đang cập nhật nội dung', " . $db->quote($homeimgfile) . ", '', " . intval($homeimgthumb) . ", 1, '4', 1, 0, 0, 0, 0)");

list ($homeimgfile, $homeimgthumb) = nv_news_check_image_exit('', $module_upload);
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows VALUES (13, 11, '11', 0, 1, '', 0, 1445391088, 1445394191, 1, 1445391060, 0, 2, 'Tuyển dụng chuyên viên đồ hoạ, kỹ thuật viên', 'tuyen-dung-chuyen-vien-do-hoa-ky-thuat-vien', 'Đang cập nhật nội dung', " . $db->quote($homeimgfile) . ", '', " . intval($homeimgthumb) . ", 1, '4', 1, 0, 0, 0, 0)");

list ($homeimgfile, $homeimgthumb) = nv_news_check_image_exit('hoptac.jpg', $module_upload);
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows VALUES (6, 10, '1,8,10', 0, 1, '', 2, 1274994722, 1275318001, 1, 1274994720, 0, 2, 'Thư mời hợp tác liên kết quảng cáo và cung cấp hosting thử nghiệm', 'Thu-moi-hop-tac', 'Hiện tại VINADES.,JSC đang tiến hành phát triển bộ mã nguồn NukeViet phiên bản 3.0 – một thế hệ CMS hoàn toàn mới với nhiều tính năng ưu việt, được đầu tư bài bản với kinh phí lớn. Với thiện chí hợp tác cùng phát triển VINADES.,JSC xin trân trọng gửi lời mời hợp tác đến Quý đối tác là các công ty cung cấp tên miền - hosting, các doanh nghiệp quan tâm và mong muốn hợp tác cùng VINADES để cùng thực hiện chung các hoạt động kinh doanh nhằm gia tăng giá trị, quảng bá thương hiệu chung cho cả hai bên.', " . $db->quote($homeimgfile) . ", '', " . intval($homeimgthumb) . ", 1, '6', 1, 1, 0, 0, 0)");

list ($homeimgfile, $homeimgthumb) = nv_news_check_image_exit('nukeviet-job.jpg', $module_upload);
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows VALUES (7, 11, '11', 0, 1, '', 2, 1307197282, 1445390968, 1, 1307197260, 0, 2, 'Tuyển dụng lập trình viên PHP phát triển NukeViet', 'tuyen-dung-lap-trinh-vien-php-phat-trien-nukeviet', 'Bạn đam mê nguồn mở? Bạn có năng khiếu lập trình PHP & MySQL? Bạn là chuyên gia đồ họa, HTML, CSS? Chúng tôi sẽ giúp bạn hiện thực hóa ước mơ của mình với một mức lương đảm bảo. Hãy gia nhập VINADES.,JSC để xây dựng mã nguồn mở hàng đầu cho Việt Nam.', " . $db->quote($homeimgfile) . ", '', " . intval($homeimgthumb) . ", 1, '2', 1, 1, 0, 0, 0)");

list ($homeimgfile, $homeimgthumb) = nv_news_check_image_exit('', $module_upload);
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows VALUES (14, 1, '1', 0, 1, '', 0, 1445391118, 1445394180, 1, 1445391060, 0, 2, 'Chương trình thực tập sinh tại công ty VINADES', 'chuong-trinh-thuc-tap-sinh-tai-cong-ty-vinades', 'Đang cập nhật nội dung', " . $db->quote($homeimgfile) . ", '', " . intval($homeimgthumb) . ", 1, '4', 1, 0, 0, 0, 0)");

list ($homeimgfile, $homeimgthumb) = nv_news_check_image_exit('', $module_upload);
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows VALUES (15, 1, '1,10', 0, 1, '', 0, 1445391135, 1445394444, 1, 1445391120, 0, 2, 'Học việc tại công ty VINADES', 'hoc-viec-tai-cong-ty-vinades', 'Đang cập nhật nội dung', " . $db->quote($homeimgfile) . ", '', " . intval($homeimgthumb) . ", 1, '4', 1, 0, 0, 0, 0)");

list ($homeimgfile, $homeimgthumb) = nv_news_check_image_exit('nukeviet-cms.jpg', $module_upload);
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows VALUES (16, 1, '1', 0, 1, '', 0, 1445391182, 1445394133, 1, 1445391120, 0, 2, 'NukeViet được Bộ GD&amp;ĐT đưa vào Hướng dẫn thực hiện nhiệm vụ CNTT năm học 2015 - 2016', 'nukeviet-duoc-bo-gd-dt-dua-vao-huong-dan-thuc-hien-nhiem-vu-cntt-nam-hoc-2015-2016', 'Trong Hướng dẫn thực hiện nhiệm vụ CNTT năm học 2015 - 2016 của Bộ Giáo dục và Đào tạo, NukeViet được đưa vào các hạng mục: Tập huấn sử dụng phần mềm nguồn mở cho giáo viên và cán bộ quản lý giáo dục; Khai thác, sử dụng và dạy học; đặc biệt phần &quot;khuyến cáo khi sử dụng các hệ thống CNTT&quot; có chỉ rõ &quot;Không nên làm website mã nguồn đóng&quot; và &quot;Nên làm NukeViet: phần mềm nguồn mở&quot;.', " . $db->quote($homeimgfile) . ", '', " . intval($homeimgthumb) . ", 1, '4', 1, 0, 0, 0, 0)");

list ($homeimgfile, $homeimgthumb) = nv_news_check_image_exit('tap-huan-pgd-ha-dong-2015.jpg', $module_upload);
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows VALUES (17, 1, '1', 0, 1, '', 0, 1445391217, 1445393997, 1, 1445391180, 0, 2, 'Hỗ trợ tập huấn và triển khai NukeViet cho các Phòng, Sở GD&amp;ĐT', 'ho-tro-tap-huan-va-trien-khai-nukeviet-cho-cac-phong-so-gd-dt', 'Trên cơ sở Hướng dẫn thực hiện nhiệm vụ CNTT năm học 2015 - 2016 của Bộ Giáo dục và Đào tạo, Công ty cổ phần phát triển nguồn mở Việt Nam và các doanh nghiệp phát triển NukeViet trong cộng đồng NukeViet đang tích cực công tác hỗ trợ cho các phòng GD&ĐT, Sở GD&ĐT triển khai 2 nội dung chính: Hỗ trợ công tác đào tạo tập huấn hướng dẫn sử dụng NukeViet và Hỗ trợ triển khai NukeViet cho các trường, Phòng và Sở GD&ĐT', " . $db->quote($homeimgfile) . ", 'Tập huấn triển khai NukeViet tại Phòng Giáo dục và Đào tạo Hà Đông - Hà Nội', " . intval($homeimgthumb) . ", 1, '4', 1, 1, 0, 0, 0)");

list ($homeimgfile, $homeimgthumb) = nv_news_check_image_exit('nukeviet-nhantaidatviet2011.jpg', $module_upload);
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows VALUES (10, 1, '1,9', 0, 1, '', 3, 1322685920, 1322686042, 1, 1322685920, 0, 2, 'Mã nguồn mở NukeViet giành giải ba Nhân tài đất Việt 2011', 'Ma-nguon-mo-NukeViet-gianh-giai-ba-Nhan-tai-dat-Viet-2011', 'Không có giải nhất và giải nhì, sản phẩm Mã nguồn mở NukeViet của VINADES.,JSC là một trong ba sản phẩm đã đoạt giải ba Nhân tài đất Việt 2011 - Lĩnh vực Công nghệ thông tin (Sản phẩm đã ứng dụng rộng rãi).', " . $db->quote($homeimgfile) . ", 'Mã nguồn mở NukeViet giành giải ba Nhân tài đất Việt 2011', " . intval($homeimgthumb) . ", 1, '6', 1, 1, 0, 0, 0)");

// News: bodyhtml, bodytext
$sth_bodyhtml = $db->prepare("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_bodyhtml_1 VALUES (:id, :bodyhtml, :sourcetext, 2, 0, 1, 1, 1, 0)");
$sth_bodytext = $db->prepare('INSERT INTO ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_bodytext VALUES ( :id, :bodytext )');

$id = 1;
$bodyhtml = "<p style=\"text-align: justify;\">Để chuyên nghiệp hóa việc phát hành mã nguồn mở NukeViet, Ban quản trị NukeViet quyết định thành lập doanh nghiệp chuyên quản NukeViet mang tên Công ty cổ phần Phát triển nguồn mở Việt Nam (Viết tắt là VINADES.,JSC), chính thức ra mắt vào ngày 25-2-2010 (trụ sở tại Hà Nội) nhằm phát triển, phổ biến hệ thống NukeViet tại Việt Nam.<br /> <br /> Theo ông Nguyễn Anh Tú, Chủ tịch HĐQT VINADES, công ty sẽ phát triển bộ mã nguồn NukeViet nhất quán theo con đường mã nguồn mở đã chọn, chuyên nghiệp và quy mô hơn bao giờ hết. Đặc biệt là hoàn toàn miễn phí đúng tinh thần mã nguồn mở quốc tế.<br /> <br /> NukeViet là một hệ quản trị nội dung mã nguồn mở (Opensource Content Management System) thuần Việt từ nền tảng PHP-Nuke và cơ sở dữ liệu MySQL. Người sử dụng thường gọi NukeViet là portal vì nó có khả năng tích hợp nhiều ứng dụng trên nền web, cho phép người sử dụng có thể dễ dàng xuất bản và quản trị các nội dung của họ lên internet hoặc intranet.<br /> <br /> NukeViet cung cấp nhiều dịch vụ và ứng dụng nhờ khả năng tăng cường tính năng thêm các module, block... tạo sự dễ dàng cài đặt, quản lý, ngay cả với những người mới tiếp cận với website. Người dùng có thể tìm hiểu thêm thông tin và tải về sản phẩm tại địa chỉ http://nukeviet.vn</p><blockquote> <p style=\"text-align: justify;\"> <em>Thông tin ra mắt công ty VINADES có thể tìm thấy trên trang 7 báo Hà Nội Mới ra ngày 25/02/2010 (<a href=\"http://hanoimoi.com.vn/newsdetail/Cong_nghe/309750/ra-mat-cong-ty-ma-nguon-mo-dau-tien-tai-viet-nam.htm\" target=\"_blank\">xem chi tiết</a>), Bản tin tiếng Anh của đài tiếng nói Việt Nam ngày 26/02/2010 (<a href=\"http://english.vovnews.vn/Home/First-opensource-company-starts-operation/20102/112960.vov\" target=\"_blank\">xem chi tiết</a>); trang 7 báo An ninh Thủ Đô số 2858 ra vào thứ 2 ngày 01/03/2010 và các trang tin tức, báo điện tử khác.</em></p></blockquote>";
$sth_bodyhtml->bindParam(':id', $id, PDO::PARAM_INT);
$sth_bodyhtml->bindValue(':sourcetext', 'http://hanoimoi.com.vn/newsdetail/Cong_nghe/309750/ra-mat-cong-ty-ma-nguon-mo-dau-tien-tai-viet-nam.htm', PDO::PARAM_STR);
$sth_bodyhtml->bindParam(':bodyhtml', $bodyhtml, PDO::PARAM_STR, strlen($bodyhtml));
$sth_bodyhtml->execute();
$bodytext = nv_news_get_bodytext($bodyhtml);
$sth_bodytext->bindParam(':id', $id, PDO::PARAM_INT);
$sth_bodytext->bindParam(':bodytext', $bodytext, PDO::PARAM_STR, strlen($bodytext));
$sth_bodytext->execute();

$id = 11;
$bodyhtml = "<div style=\"text-align: justify;\">Có hiệu lực từ ngày 20/1/2015, Thông tư này thay thế cho Thông tư 41/2009/TT-BTTTT (Thông tư 41) ngày 30/12/2009 ban hành Danh mục các sản phẩm phần mềm nguồn mở đáp ứng yêu cầu sử dụng trong cơ quan, tổ chức nhà nước.<br />\r\n<br />\r\nSản phẩm phần mềm nguồn mở được ưu tiên mua sắm, sử dụng trong cơ quan, tổ chức nhà nước trong Thông tư 41/2009/TT-BTTTT vừa được Bộ TT&amp;TT ban hành, là những&nbsp;sản phẩm đã đáp ứng các tiêu chí về tính năng kỹ thuật cũng như tính mở và bền vững, và NukeViet là một trong số đó.</div>\r\n\r\n<p style=\"text-align: justify;\">Cụ thể, theo Thông tư 20, sản phẩm phần mềm nguồn mở được ưu tiên mua sắm, sử dụng trong cơ quan, tổ chức nhà nước phải đáp các tiêu chí về chức năng, tính năng kỹ thuật bao gồm: phần mềm có các chức năng, tính năng kỹ thuật phù hợp với các yêu cầu nghiệp vụ hoặc các quy định, hướng dẫn tương ứng về ứng dụng CNTT trong các cơ quan, tổ chức nhà nước; phần mềm đáp ứng được yêu cầu tương thích với hệ thống thông tin, cơ sở dữ liệu hiện có của các cơ quan, tổ chức.</p>\r\n\r\n<p style=\"text-align: justify;\">Bên cạnh đó, các sản phẩm phần mềm nguồn mở được ưu tiên mua sắm, sử dụng trong cơ quan, tổ chức nhà nước còn phải đáp ứng tiêu chí về tính mở và tính bền vững của phần mềm. Cụ thể, phần mềm phải đảm bảo các quyền: tự do sử dụng phần mềm không phải trả phí bản quyền, tự do phân phối lại phần mềm, tự do sửa đổi phần mềm theo nhu cầu sử dụng, tự do phân phối lại phần mềm đã chỉnh sửa (có thể thu phí hoặc miễn phí); phần mềm phải có bản mã nguồn, bản cài đặt được cung cấp miễn phí trên mạng; có điểm ngưỡng thất bại PoF từ 50 điểm trở xuống và điểm mô hình độ chín nguồn mở OSMM từ 60 điểm trở lên.</p>\r\n\r\n<p style=\"text-align: justify;\">Căn cứ những tiêu chuẩn trên, thông tư 20 quy định cụ thể Danh mục 31 sản phẩm thuộc 11 loại phần mềm được ưu tiên mua sắm, sử dụng trong cơ quan, tổ chức nhà nước.&nbsp;NukeViet thuộc danh mục hệ quản trị nội dung nguồn mở. Chi tiết thông tư và danh sách 31 sản phẩm phần mềm nguồn mở được ưu tiên mua sắm, sử dụng trong cơ quan, tổ chức nhà nước có&nbsp;<a href=\"http://vinades.vn/vi/download/van-ban-luat/Thong-tu-20-2014-TT-BTTTT/\" target=\"_blank\">tại đây</a>.</p>\r\n\r\n<p style=\"text-align: justify;\">Thông tư 20/2014/TT-BTTTT quy định rõ: Các cơ quan, tổ chức nhà nước khi có nhu cầu sử dụng vốn nhà nước để đầu tư xây dựng, mua sắm hoặc thuê sử dụng các loại phần mềm có trong Danh mục hoặc các loại phần mềm trên thị trường đã có sản phẩm phần mềm nguồn mở tương ứng thỏa mãn các tiêu chí trên (quy định tại Điều 3 Thông tư 20) thì phải&nbsp;ưu tiên lựa chọn các sản phẩm phần mềm nguồn mở tương ứng, đồng thời phải thể hiện rõ sự ưu tiên này trong các tài liệu&nbsp;như thiết kế sơ bộ, thiết kế thi công, kế hoạch đấu thầu, kế hoạch đầu tư, hồ sơ mời thầu, yêu cầu chào hàng, yêu cầu báo giá hoặc các yêu cầu mua sắm khác.</p>\r\n\r\n<p style=\"text-align: justify;\">Đồng thời,&nbsp;các cơ quan, tổ chức nhà nước phải đảm bảo không đưa ra các yêu cầu, điều kiện, tính năng kỹ thuật có thể dẫn đến việc loại bỏ các sản phẩm phần mềm nguồn mở&nbsp;trong các tài liệu như thiết kế sơ bộ, thiết kế thi công, kế hoạch đấu thầu, kế hoạch đầu tư, hồ sơ mời thầu, yêu cầu chào hàng, yêu cầu báo giá hoặc các yêu cầu mua sắm khác.</p>\r\n\r\n<p style=\"text-align: justify;\">Như vậy, sau thông tư số 08/2010/TT-BGDĐT của Bộ GD&amp;ĐT ban hành ngày 01-03-2010 quy định về sử dụng phần mềm tự do mã nguồn mở trong các cơ sở giáo dục trong đó đưa NukeViet vào danh sách các mã nguồn mở được khuyến khích sử dụng trong giáo dục, thông tư 20/2014/TT-BTTTT đã mở đường cho NukeViet vào sử dụng cho các cơ quan, tổ chức nhà nước. Các đơn vị hỗ trợ triển khai NukeViet cho các cơ quan nhà nước có thể sử dụng quy định này để được ưu tiên triển khai cho các dự án website, cổng thông tin cho các cơ quan, tổ chức nhà nước.<br />\r\n<br />\r\nThời gian tới, Công ty cổ phần phát triển nguồn mở Việt Nam (<a href=\"http://vinades.vn/\" target=\"_blank\">VINADES.,JSC</a>) - đơn vị chủ quản của NukeViet - sẽ cùng với Ban Quản Trị NukeViet tiếp tục hỗ trợ các doanh nghiệp đào tạo nguồn nhân lực chính quy phát triển NukeViet nhằm cung cấp dịch vụ ngày một tốt hơn cho chính phủ và các cơ quan nhà nước, từng bước xây dựng và hình thành liên minh các doanh nghiệp phát triển NukeViet, đưa sản phẩm phần mềm nguồn mở Việt không những phục vụ tốt thị trường Việt Nam mà còn từng bước tiến ra thị trường khu vực và các nước đang phát triển khác trên thế giới nhờ vào lợi thế phần mềm nguồn mở đang được chính phủ nhiều nước ưu tiên phát triển.</p>";
$sth_bodyhtml->bindParam(':id', $id, PDO::PARAM_INT);
$sth_bodyhtml->bindValue(':sourcetext', 'mic.gov.vn', PDO::PARAM_STR);
$sth_bodyhtml->bindParam(':bodyhtml', $bodyhtml, PDO::PARAM_STR, strlen($bodyhtml));
$sth_bodyhtml->execute();
$bodytext = nv_news_get_bodytext($bodyhtml);
$sth_bodytext->bindParam(':id', $id, PDO::PARAM_INT);
$sth_bodytext->bindParam(':bodytext', $bodytext, PDO::PARAM_STR, strlen($bodytext));
$sth_bodytext->execute();

$id = 6;
$bodyhtml = "<div style=\"text-align: center;\"><h2 style=\"color: rgb(255, 69, 0);\"> THƯ MỜI HỢP TÁC</h2> <h4> TRONG VIỆC LIÊN KẾT QUẢNG CÁO, CUNG CẤP HOSTING THỬ NGHIỆM PHÁT TRIỂN</h4> <h2> MÃ NGUỒN MỞ NUKEVIET</h2> </div> <p style=\"text-align: justify; line-height: 130%; font-weight: bold;\">  </p> <p style=\"text-align: justify; line-height: 130%; font-weight: bold;\"> Kính gửi: QUÍ KHÁCH VÀ ĐỐI TÁC</p> <p style=\"text-align: justify; line-height: 130%; font-style: italic; text-indent: 1cm;\"> Lời đầu tiên, Ban giám đốc công ty cổ phần Phát Triển Nguồn Mở Việt Nam (VINADES.,JSC) xin gửi đến Quý đối tác lời chào trân trọng, lời chúc may mắn và thành công. Tiếp đến chúng tôi xin được giới thiệu và ngỏ lời mời hợp tác kinh doanh.</p> <p style=\"text-align: justify; line-height: 130%; font-style: italic; text-indent: 1cm;\"> VINADES.,JSC ra đời nhằm chuyên nghiệp hóa việc phát hành mã nguồn mở NukeViet. Đồng thời khai thác các dự án từ NukeViet tạo kinh phí phát triển bền vững cho mã nguồn này.</p> <p style=\"text-align: justify; line-height: 130%; font-style: italic; text-indent: 1cm;\"> NukeViet là hệ quản trị nội dung, là website đa năng đầu tiên của Việt Nam do cộng đồng người Việt phát triển. Có nhiều lợi thế như cộng đồng người sử dụng đông đảo nhất tại Việt Nam hiện nay, sản phẩm thuần Việt, dễ sử dụng, dễ phát triển.</p> <p style=\"text-align: justify; line-height: 130%; font-style: italic; text-indent: 1cm;\"> Hiện tại VINADES.,JSC đang tiến hành phát triển bộ mã nguồn NukeViet phiên bản 3.0 – một thế hệ CMS hoàn toàn mới với nhiều tính năng ưu việt, được đầu tư bài bản với kinh phí lớn.</p> <p style=\"text-align: justify; line-height: 130%; font-style: italic; text-indent: 1cm;\"> Với thiện chí hợp tác cùng phát triển VINADES.,JSC xin trân trọng gửi lời mời hợp tác đến Quý đối tác là các công ty cung cấp tên miền - hosting, các doanh nghiệp quan tâm và mong muốn hợp tác cùng VINADES để cùng thực hiện chung các hoạt động kinh doanh nhằm gia tăng giá trị, quảng bá thương hiệu chung cho cả hai bên.</p> <p style=\"text-align: justify; line-height: 130%; text-indent: 1cm; font-weight: bold;\"> Phương thức hợp tác nhưsau:</p> <p style=\"text-align: justify; line-height: 130%; font-weight: bold;\"> 1.Quảng cáo, trao đổi banner, liên kết website:</p> <p style=\"text-align: justify; line-height: 130%;\"> a. Mô tả hình thức:</p> <p style=\"text-align: justify; line-height: 130%; text-indent: 1cm;\"> - Quảng cáo trên website &amp; hệ thống kênh truyền thông của 2 bên.</p> <p style=\"text-align: justify; line-height: 130%; text-indent: 1cm;\"> - Quảng cáo trên các phiên bản phát hành của mã nguồn mở NukeViet.</p> <p style=\"text-align: justify; line-height: 130%;\"> b, Lợi ích:</p> <p style=\"text-align: justify; line-height: 130%; text-indent: 1cm;\"> - Quảng bá rộng rãi cho đối tượng của 2 bên.</p> <p style=\"text-align: justify; line-height: 130%; text-indent: 1cm;\"> - Giảm chi phí quảng bá cho 2 bên.</p> <p style=\"text-align: justify; line-height: 130%;\"> c, Trách nhiệm:</p> <p style=\"text-align: justify; line-height: 130%; text-indent: 1cm;\"> - Hai bên sẽ thỏa thuận và đưa quảng cáo của mình vào website của đối tác. Thỏa thuận vị trí, kích thước và trang đặt banner quảng cáo nhằm mang lại hiệu quả cao cho cả hai bên.</p> <p style=\"text-align: justify; line-height: 130%; text-indent: 1cm;\"> - Mở forum hỗ trợ người dùng hosting ngay tại diễn đàn NukeViet.VN để quý công ty dễ dàng hỗ trợ người sử dụng cũng như thực hiện các kế hoạch truyền thông của mình tới cộng đồng NukeViet.</p> <p style=\"text-align: justify; line-height: 130%; font-weight: bold;\"> 2.Hợp tác cung cấp hosting thử nghiệm NukeViet:</p> <p style=\"text-align: justify; line-height: 130%;\"> a. Mô tả hình thức:</p> <p style=\"text-align: justify; line-height: 130%; text-indent: 1cm;\"> - Hai bên ký hợp đồng nguyên tắc &amp; thỏa thuận hợp tác trong việc hợp tác phát triển mã nguồn mở NukeViet. Theo đó:</p> <p style=\"text-align: justify; line-height: 130%; text-indent: 1cm;\"> + Phía đối tác cung cấp mỗi loại 1 gói hosting đại lý cho VINADES.,JSC để chúng tôi test trong quá trình phát triển mã nguồn mở NukeViet, để đảm bảo NukeViet sẵn sàng tương thích với hosting của quý khách ngay khi ra mắt.</p> <p style=\"text-align: justify; line-height: 130%; text-indent: 1cm;\"> + VINADES.,JSC sẽ công báo thông tin chứng nhận host của phía đối tác là phù hợp, tương thích tốt nhất với NukeViet tới cộng đồng những người phát triển và sử dụng NukeViet.</p> <p style=\"text-align: justify; line-height: 130%;\"> b. Lợi ích:</p> <p style=\"text-align: justify; line-height: 130%; text-indent: 1cm;\"> - Mở rộng thị trường theo cả hướng đối tượng.</p> <p style=\"text-align: justify; line-height: 130%; text-indent: 1cm;\"> - Tiết kiệm chi phí –nâng cao hiệu quả kinh doanh.</p> <p style=\"text-align: justify; line-height: 130%;\"> c. Trách nhiệm:</p> <p style=\"text-align: justify; line-height: 130%; text-indent: 1cm;\"> - Bên đối tác cung cấp miễn phí host để VINADES.,JSC thực hiện việc test tương thích mã nguồn NukeViet trên các gói hosting của đối tác.</p> <p style=\"text-align: justify; line-height: 130%; text-indent: 1cm;\"> - VINADES.,JSC công bố tới cộng đồng về kết quả chứng nhận chất lượng host của phía đối tác.</p> <p style=\"text-align: justify; line-height: 130%; font-weight: bold;\"> 3,Hợp tác nhân lực hỗ trợ người sử dụng:</p> <p style=\"text-align: justify; line-height: 130%;\"> a, Mô tả hình thức:</p> <p style=\"text-align: justify; line-height: 130%; text-indent: 1cm;\"> - Hai bên sẽ hỗ trợ lẫn nhau trong quá trình giải quyết các yêu cầu của khách hàng.</p> <p style=\"text-align: justify; line-height: 130%; text-indent: 1cm;\"> + Bên đối tác gửi các yêu cầu của khách hàng về mã nguồn NukeViet tới VINADES.,JSC</p> <p style=\"text-align: justify; line-height: 130%; text-indent: 1cm;\"> + VINADES gửi các yêu cầu của khách hàng có liên quan đến dịch vụ hosting tới phía đối tác.</p> <p style=\"text-align: justify; line-height: 130%;\"> b, Lợi ích:</p> <p style=\"text-align: justify; line-height: 130%; text-indent: 1cm;\"> - Giảm thiểu chi phí, nhân lực hỗ trợ khách hàng của cả 2 bên.</p> <p style=\"text-align: justify; line-height: 130%; text-indent: 1cm;\"> - Tăng hiệu quả hỗ trợ khách hàng.</p> <p style=\"text-align: justify; line-height: 130%;\"> c, Trách nhiệm:</p> <p style=\"text-align: justify; line-height: 130%; text-indent: 1cm;\"> - Khi nhận được yêu cầu hỗ trợ VINADES hoặc bên đối tác cần ưu tiên xử lý nhanh gọn nhằm nâng cao hiệu quả của sự hợp tác song phưong này.</p> <p style=\"text-align: justify; line-height: 130%; font-weight: bold;\"> 4. Các hình thức khác:</p> <p style=\"text-align: justify; line-height: 130%; text-indent: 1cm;\"> Ngoài các hình thức đã đề xuất ở trên, là đơn vị phát hành mã nguồn mở NukeViet chúng tôi có thể phát hành quảng cáo trên giao diện phần mềm, trên các bài viết giới thiệu xuất hiện ngay sau khi cài đặt phần mềm… chúng tôi tin tưởng rằng với lượng phát hành lên đến hàng chục ngàn lượt tải về cho mỗi phiên bản là một cơ hội quảng cáo rất hiệu quả đến cộng đồng Webmaster Việt Nam.</p> <p style=\"text-align: justify; line-height: 130%; text-indent: 1cm;\"> Với mong muốn tạo nên cộng đồng phát triển và sử dụng NukeViet rộng lớn đúng như mục tiêu đề ra,chúng tôi luôn linh động trong các hình thức hợp tác nhằm mang lại sự thuận tiện cho đối tác cũng như mục tiêu hợp tác đa phương. Chúng tôi sẽ tiếp nhận các hình thức hợp tác khác mà bên đối tác trình bày hợp lý và hiệu quả, mong nhận được thêm nhiều hình thức hợp tác khác từ đối tác. Phương châm của chúng tôi “Cùng hợp tác để phát triển”.</p> <p style=\"text-align: justify; line-height: 130%; font-style: italic; text-indent: 1cm;\"> Trân trọng cảm ơn, rất mong được hợp tác cùng quý vị.</p> <span style=\"font-weight: bold;\">Thông tin liên hệ:</span> <p style=\"text-align: justify;\"> CÔNG TY CỔ PHẦN PHÁT TRIỂN NGUỒN MỞ VIỆT NAM (VINADES.,JSC)</p> <p style=\"text-align: justify; text-indent: 1cm;\"> Trụ sở chính: Phòng 2004 - Tòa nhà CT2 Nàng Hương, 583 Nguyễn Trãi, Hà Nội.</p> <p style=\"text-align: justify; text-indent: 1cm;\"> Điện thoại: (84-4) 85 872007</p> <p style=\"text-align: justify; text-indent: 1cm;\"> Fax: (84-4) 35 500 914</p> <p style=\"text-align: justify; text-indent: 1cm;\"> Website: <a href=\"http://www.vinades.vn/\">www.vinades.vn</a> – <a href=\"http://www.nukeviet.vn/\">www.nukeviet.vn</a></p> <p style=\"text-align: justify; text-indent: 1cm;\"> Email: <a href=\"mailto:contact@vinades.vn\">contact@vinades.vn</a></p>";
$sth_bodyhtml->bindParam(':id', $id, PDO::PARAM_INT);
$sth_bodyhtml->bindValue(':sourcetext', 'http://vinades.vn/vi/news/thong-cao-bao-chi/Thu-moi-hop-tac-6/', PDO::PARAM_STR);
$sth_bodyhtml->bindParam(':bodyhtml', $bodyhtml, PDO::PARAM_STR, strlen($bodyhtml));
$sth_bodyhtml->execute();
$bodytext = nv_news_get_bodytext($bodyhtml);
$sth_bodytext->bindParam(':id', $id, PDO::PARAM_INT);
$sth_bodytext->bindParam(':bodytext', $bodytext, PDO::PARAM_STR, strlen($bodytext));
$sth_bodytext->execute();

$id = 7;
$bodyhtml = "Công ty cổ phần phát triển nguồn mở Việt Nam (VINADES.,JSC) đang thu hút tuyển dụng nhân tài là các lập trình viên PHP và MySQL, Chuyên Viên Đồ Hoạ để làm việc cho công ty, hiện thực hóa ước mơ một nguồn mở chuyên nghiệp cho Việt Nam vươn ra thế giới.<br />\r\n<br />\r\nTại VINADES.,JSC bạn sẽ được tham gia các dự án của công ty, tham gia xây dựng và phát triển bộ nhân hệ thống NukeViet, được học hỏi và trau dồi nâng cao kiến thức và kỹ năng cá nhân.\r\n<p style=\"text-align: justify;\"><strong>1. Vị trí dự tuyển</strong>: Chuyên viên đồ hoạ; Lập trình viên.</p>\r\n\r\n<p style=\"text-align: justify;\"><strong>2. Mô tả công việc:</strong></p>\r\nVới vị trí lập trình viên PHP &amp; MySQL: Viết module trên nền NukeViet, tham gia phát triển hệ thống NukeViet.\r\n\r\n<p style=\"text-align: justify;\">Nếu là chuyên viên đồ họa, kỹ thuật viên cắt giao diện... bạn có thể đảm nhiệm một trong các công việc sau:</p>\r\n\r\n<p style=\"margin-left: 40px; text-align: justify;\">+ Vẽ và cắt giao diện.</p>\r\n\r\n<p style=\"margin-left: 40px; text-align: justify;\">+ Valid CSS, xHTML.</p>\r\n\r\n<p style=\"margin-left: 40px; text-align: justify;\">+ Ghép giao diện cho hệ thống.</p>\r\n<strong>3. Yêu cầu: </strong><br />\r\n<br />\r\nLập trình viên PHP &amp; MySQL: Thành thạo PHP, MySQL. Biết CSS, XHTML, JavaScript là một ưu thế.<br />\r\n<br />\r\nChuyên viên đồ họa: Sử dụng thành thạo một trong các phần mềm Photoshop, illustrator, 3Dmax, coreldraw. Biết CSS, xHTML.\r\n<p style=\"text-align: justify; margin-left: 40px;\">+ Trình độ tối thiểu cho người làm đồ họa web: Biết vẽ giao diện hoặc cắt PSD ra xHTML &amp; CSS.</p>\r\n\r\n<p style=\"text-align: justify; margin-left: 40px;\">+ Ưu tiên người cắt giao diện đạt chuẩn W3C (Test trên Internet Explorer 7+, FireFox 3+, Chrome 8+, Opera 10+)</p>\r\nChúng tôi ưu tiên các ứng viên có kỹ năng làm việc độc lập, làm việc theo nhóm, có tinh thần trách nhiệm cao, chủ động trong công việc.\r\n\r\n<p style=\"text-align: justify;\"><strong>4: Quyền lợi:</strong></p>\r\n\r\n<p style=\"text-align: justify;\"><strong>-</strong> Lương: thoả thuận, trả qua ATM.</p>\r\n\r\n<p style=\"text-align: justify;\">- Thưởng theo dự án, các ngày lễ tết.</p>\r\n\r\n<p style=\"text-align: justify;\">- Hưởng các chế độ khác theo quy định của công ty và pháp luật: Bảo hiểm y tế, bảo hiểm xã hội...</p>\r\n\r\n<p style=\"text-align: justify;\"><strong>5. Thời gian làm việc:</strong> Toàn thời gian cố định hoặc làm <strong>online</strong>.</p>\r\n\r\n<p style=\"text-align: justify;\"><strong>6. Hạn nộp hồ sơ</strong>: Không hạn chế, vui lòng kiểm tra tại <a href=\"http://vinades.vn/vi/news/Tuyen-dung/\" target=\"_blank\">http://vinades.vn/vi/news/Tuyen-dung/</a></p>\r\n\r\n<p style=\"text-align: justify;\"><strong>7. Hồ sơ bao gồm:</strong></p>\r\n\r\n<p style=\"text-align: justify;\">&nbsp;&nbsp;<strong>&nbsp; *&nbsp; Cách thức đăng ký dự tuyển</strong>: Làm Hồ sơ xin việc (file mềm) và gửi về hòm thư tuyendung@vinades.vn<br />\r\n&nbsp;&nbsp;&nbsp; *&nbsp; <strong>Nội dung hồ sơ xin việc file mềm gồm</strong>:<br />\r\n<br />\r\n<strong>+ Đơn xin việc:</strong> Tự biên soạn.</p>\r\n\r\n<p style=\"text-align: justify;\"><strong>+ Thông tin ứng viên:</strong> Theo mẫu của VINADES.,JSC (dowload tại đây: <strong><u><a href=\"http://vinades.vn/vi/download/Thong-tin-ung-vien/Mau-ly-lich-ung-vien/\" target=\"_blank\" title=\"Mẫu lý lịch ứng viên\">Mẫu lý lịch ứng viên</a></u></strong>)<br />\r\n<br />\r\nChi tiết vui lòng tham khảo tại: <a href=\"http://vinades.vn/vi/news/Tuyen-dung/\" target=\"_blank\">http://vinades.vn/vi/news/Tuyen-dung/</a><br />\r\n<br />\r\nMọi thắc mắc vui lòng liên hệ:<br />\r\n<br />\r\n<strong>Công ty cổ phần phát triển nguồn mở Việt Nam.</strong><br />\r\nTrụ sở chính: Phòng 2004 - Tòa nhà CT2 Nàng Hương, 583 Nguyễn Trãi, Hà Nội.</p>\r\n\r\n<div>- Tel: +84-4-85872007 - Fax: +84-4-35500914<br />\r\n- Email: <a href=\"mailto:contact@vinades.vn\">contact@vinades.vn</a> - Website: <a href=\"http://www.vinades.vn/\">http://www.vinades.vn</a></div>";
$sth_bodyhtml->bindParam(':id', $id, PDO::PARAM_INT);
$sth_bodyhtml->bindValue(':sourcetext', 'http://vinades.vn/vi/news/Tuyen-dung/', PDO::PARAM_STR);
$sth_bodyhtml->bindParam(':bodyhtml', $bodyhtml, PDO::PARAM_STR, strlen($bodyhtml));
$sth_bodyhtml->execute();
$bodytext = nv_news_get_bodytext($bodyhtml);
$sth_bodytext->bindParam(':id', $id, PDO::PARAM_INT);
$sth_bodytext->bindParam(':bodytext', $bodytext, PDO::PARAM_STR, strlen($bodytext));
$sth_bodytext->execute();

$id = 12;
$bodyhtml = "Đang cập nhật nội dung";
$sth_bodyhtml->bindParam(':id', $id, PDO::PARAM_INT);
$sth_bodyhtml->bindValue(':sourcetext', '', PDO::PARAM_STR);
$sth_bodyhtml->bindParam(':bodyhtml', $bodyhtml, PDO::PARAM_STR, strlen($bodyhtml));
$sth_bodyhtml->execute();
$bodytext = nv_news_get_bodytext($bodyhtml);
$sth_bodytext->bindParam(':id', $id, PDO::PARAM_INT);
$sth_bodytext->bindParam(':bodytext', $bodytext, PDO::PARAM_STR, strlen($bodytext));
$sth_bodytext->execute();

$id = 13;
$bodyhtml = "Đang cập nhật nội dung";
$sth_bodyhtml->bindParam(':id', $id, PDO::PARAM_INT);
$sth_bodyhtml->bindValue(':sourcetext', '', PDO::PARAM_STR);
$sth_bodyhtml->bindParam(':bodyhtml', $bodyhtml, PDO::PARAM_STR, strlen($bodyhtml));
$sth_bodyhtml->execute();
$bodytext = nv_news_get_bodytext($bodyhtml);
$sth_bodytext->bindParam(':id', $id, PDO::PARAM_INT);
$sth_bodytext->bindParam(':bodytext', $bodytext, PDO::PARAM_STR, strlen($bodytext));
$sth_bodytext->execute();

$id = 14;
$bodyhtml = "Đang cập nhật nội dung";
$sth_bodyhtml->bindParam(':id', $id, PDO::PARAM_INT);
$sth_bodyhtml->bindValue(':sourcetext', '', PDO::PARAM_STR);
$sth_bodyhtml->bindParam(':bodyhtml', $bodyhtml, PDO::PARAM_STR, strlen($bodyhtml));
$sth_bodyhtml->execute();
$bodytext = nv_news_get_bodytext($bodyhtml);
$sth_bodytext->bindParam(':id', $id, PDO::PARAM_INT);
$sth_bodytext->bindParam(':bodytext', $bodytext, PDO::PARAM_STR, strlen($bodytext));
$sth_bodytext->execute();

$id = 15;
$bodyhtml = "Đang cập nhật nội dung";
$sth_bodyhtml->bindParam(':id', $id, PDO::PARAM_INT);
$sth_bodyhtml->bindValue(':sourcetext', '', PDO::PARAM_STR);
$sth_bodyhtml->bindParam(':bodyhtml', $bodyhtml, PDO::PARAM_STR, strlen($bodyhtml));
$sth_bodyhtml->execute();
$bodytext = nv_news_get_bodytext($bodyhtml);
$sth_bodytext->bindParam(':id', $id, PDO::PARAM_INT);
$sth_bodytext->bindParam(':bodytext', $bodytext, PDO::PARAM_STR, strlen($bodytext));
$sth_bodytext->execute();

$id = 16;
$bodyhtml = "<div class=\"details-content clearfix\" id=\"bodytext\"><strong>Hướng dẫn thực hiện nhiệm vụ CNTT năm học 2015 - 2016 của Bộ Giáo dục và Đào tạo có gì mới?</strong><br  /><br  />Trong các hướng dẫn thực hiện nhiệm vụ CNTT từ năm 2010 đến nay liên tục chỉ đạo việc đẩy mạnh công tác triển khai sử dụng phần mềm nguồn mở trong nhà trường và các cơ quan quản lý giáo dục. Tuy nhiên Hướng dẫn thực hiện nhiệm vụ CNTT năm học 2015 - 2016 của Bộ Giáo dục và Đào tạo có nhiều thay đổi mạnh mẽ đáng chú ý, đặc biệt việc chỉ đạo triển khai các phần mềm nguồn mở vào trong các cơ sở quản lý giao dục được rõ ràng và cụ thể hơn rất nhiều.<br  /><br  />Một điểm thay đổi đáng chú ý đối với phần mềm nguồn mở, trong đó đã thay hẳn thuật ngữ &quot;phần mềm tự do mã nguồn mở&quot; hoặc &quot;phần mềm mã nguồn mở&quot; thành &quot;phần mềm nguồn mở&quot;, phản ánh xu thế sử dụng thuật ngữ phần mềm nguồn mở đã phổ biến trong cộng đồng nguồn mở thời gian vài năm trở lại đây.<br  /><br  /><strong>NukeViet - Phần mềm nguồn mở Việt - không chỉ được khuyến khích mà đã được hướng dẫn thực thi</strong><br  /><br  />Từ 5 năm trước, thông tư số 08/2010/TT-BGDĐT của Bộ GD&amp;ĐTquy định về sử dụng phần mềm tự do mã nguồn mở trong các cơ sở giáo dục, NukeViet đã được đưa vào danh sách các mã nguồn mở <strong>được khuyến khích sử dụng trong giáo dục</strong>. Tuy nhiên, việc sử dụng chưa được thực hiện một cách đồng bộ mà chủ yếu làm nhỏ lẻ rải rác tại một số trường, Phòng và Sở GD&amp;ĐT.<br  /><br  />Trong Hướng dẫn thực hiện nhiệm vụ CNTT năm học 2015 - 2016 của Bộ Giáo dục và Đào tạo lần này, NukeViet&nbsp; không chỉ được khuyến khích mà đã được hướng dẫn thực thi, không những thế NukeViet còn được đưa vào hầu hết các nhiệm vụ chính, cụ thể:<div><div><div>&nbsp;</div>- <strong>Nhiệm vụ số 5</strong> &quot;<strong>Công tác bồi dưỡng ứng dụng CNTT cho giáo viên và cán bộ quản lý giáo dục</strong>&quot;, mục 5.1 &quot;Một số nội dung cần bồi dưỡng&quot; có ghi &quot;<strong>Tập huấn sử dụng phần mềm nguồn mở NukeViet.</strong>&quot;<br  />&nbsp;</div>- <strong>Nhiệm vụ số 10 &quot;Khai thác, sử dụng và dạy học bằng phần mềm nguồn mở</strong>&quot; có ghi: &quot;<strong>Khai thác và áp dụng phần mềm nguồn mở NukeViet trong giáo dục.&quot;</strong><br  />&nbsp;</div>- Phụ lục văn bản, có trong nội dung &quot;Khuyến cáo khi sử dụng các hệ thống CNTT&quot;, hạng mục số 3 ghi rõ &quot;<strong>Không nên làm website mã nguồn đóng&quot; và &quot;Nên làm NukeViet: phần mềm nguồn mở&quot;.</strong><br  />&nbsp;<div>Hiện giờ văn bản này đã được đăng lên website của Bộ GD&amp;ĐT: <a href=\"http://moet.gov.vn/?page=1.10&amp;view=983&amp;opt=brpage\" target=\"_blank\">http://moet.gov.vn/?page=1.10&amp;view=983&amp;opt=brpage</a></div><p><br  />Hoặc có thể tải về tại đây: <a href=\"http://vinades.vn/vi/download/van-ban-luat/Huong-dan-thuc-hien-nhiem-vu-CNTT-nam-hoc-2015-2016/\" target=\"_blank\">http://vinades.vn/vi/download/van-ban-luat/Huong-dan-thuc-hien-nhiem-vu-CNTT-nam-hoc-2015-2016/</a></p><blockquote><p><em>Trên cơ sở hướng dẫn của Bộ GD&amp;ĐT, Công ty cổ phần phát triển nguồn mở Việt Nam và các doanh nghiệp phát triển NukeViet trong cộng đồng NukeViet đang tích cực công tác hỗ trợ cho các phòng GD&amp;ĐT, Sở GD&amp;ĐT triển khai 2 nội dung chính: Hỗ trợ công tác đào tạo tập huấn hướng dẫn sử dụng NukeViet và Hỗ trợ triển khai NukeViet cho các trường, Phòng và Sở GD&amp;ĐT.<br  /><br  />Các Phòng, Sở GD&amp;ĐT có nhu cầu có thể xem thêm thông tin chi tiết tại đây: <a href=\"http://vinades.vn/vi/news/thong-cao-bao-chi/Ho-tro-trien-khai-dao-tao-va-trien-khai-NukeViet-cho-cac-Phong-So-GD-DT-264/\" target=\"_blank\">Hỗ trợ triển khai đào tạo và triển khai NukeViet cho các Phòng, Sở GD&amp;ĐT</a></em></p></blockquote></div>";
$sth_bodyhtml->bindParam(':id', $id, PDO::PARAM_INT);
$sth_bodyhtml->bindValue(':sourcetext', '', PDO::PARAM_STR);
$sth_bodyhtml->bindParam(':bodyhtml', $bodyhtml, PDO::PARAM_STR, strlen($bodyhtml));
$sth_bodyhtml->execute();
$bodytext = nv_news_get_bodytext($bodyhtml);
$sth_bodytext->bindParam(':id', $id, PDO::PARAM_INT);
$sth_bodytext->bindParam(':bodytext', $bodytext, PDO::PARAM_STR, strlen($bodytext));
$sth_bodytext->execute();

$id = 17;
$bodyhtml = "<div class=\"details-content clearfix\" id=\"bodytext\"><span style=\"font-size:16px;\"><strong>Hỗ trợ công tác đào tạo tập huấn hướng dẫn sử dụng phần mềm nguồn mở NukeViet</strong></span><br  /><br  />Công tác hỗ trợ công tác đào tạo tập huấn hướng dẫn sử dụng phần mềm nguồn mở NukeViet sẽ được thực hiện bởi đội ngũ chuyên gia giàu kinh nghiệm về NukeViet được tuyển chọn từ lực lượng lập trình viên, chuyên viên kỹ thuật hiện đang tham gia phát triển và hỗ trợ về NukeViet từ Ban Quản Trị NukeViet và Công ty cổ phần phát triển nguồn mở Việt Nam và các đối tác thuộc Liên minh phần mềm giáo dục nguồn mở NukeViet.<br  /><br  />Với kinh nghiệm tập huấn đã được tổ chức thành công cho nhiều Phòng giáo dục và đào tạo, các chuyên gia về NukeViet sẽ giúp chuyển giao giáo trình, chương trình, kịch bản đào tạo cho các Phòng, Sở GD&amp;ĐT; hỗ trợ các giáo viên và cán bộ quản lý giáo dục sử dụng trong suốt thời gian sau đào tạo.<br  /><br  />Đặc biệt, đối với các đơn vị sử dụng NukeViet làm website và cổng thông tin đồng bộ theo quy mô cấp Phòng và Sở, cán bộ tập huấn của NukeViet sẽ có nhiều chương trình hỗ trợ khác như chương trình thi đua giữa các website sử dụng NukeViet trong cùng đơn vị cấp Phòng, Sở và trên toàn quốc; Chương trình báo cáo và giám sát và xếp hạng website hàng tháng; Chương trình tập huấn nâng cao trình độ sử dụng NukeViet hàng năm cho giáo viên và cán bộ quản lý giáo dục đang thực hiện công tác quản trị các hệ thống sử dụng nền tảng NukeViet.<br  /><br  /><span style=\"font-size:16px;\"><strong>Hỗ trợ triển khai NukeViet cho các trường, Phòng và Sở GD&amp;ĐT</strong></span><br  /><br  />Nhằm hỗ trợ triển khai NukeViet cho các trường, Phòng và Sở GD&amp;ĐT một cách toàn diện, đồng bộ và tiết kiệm, hiện tại, Liên minh phần mềm nguồn mở giáo dục NukeViet chuẩn bị ra mắt. Liên minh này do Công ty cổ phần phát triển nguồn mở Việt Nam đứng dầu và thực hiện việc điều phối công các hỗ trợ và phối hợp giữa các đơn vị trên toàn quốc. Thành viên của liên minh là các doanh nghiệp cung cấp sản phẩm và dịch vụ phần mềm hỗ trợ cho giáo dục (kể cả những đơn vị chỉ tham gia lập trình và những đơn vị chỉ tham gia khai thác thương mại). Liên minh sẽ cùng nhau làm việc để xây dựng một hệ thống phần mềm thống nhất cho giáo dục, có khả năng liên thông và kết nối với nhau, hoàn toàn dựa trên nền tảng phần mềm nguồn mở. Liên minh cũng hỗ trợ và phân phối phần mềm cho các đơn vị làm phần mềm trong ngành giáo dục với mục tiêu là tiết kiệm tối đa chi phí trong khâu thương mại, mang tới cơ hội cho các đơn vị làm phần mềm giáo dục mà không cần phải lo lắng về việc phân phối phần mềm. Các doanh nghiệp quan tâm đến cơ hội kinh doanh bằng phần mềm nguồn mở, muốn tìm hiểu và tham gia liên minh có thể đăng ký tại đây: <a href=\"http://edu.nukeviet.vn/lienminh-dangky.html\" target=\"_blank\">http://edu.nukeviet.vn/lienminh-dangky.html</a><br  /><br  />Liên minh phần mềm nguồn mở giáo dục NukeViet đang cung cấp giải pháp cổng thông tin chuyên dùng cho phòng và Sở GD&amp;ĐT (NukeViet Edu Gate) cung cấp dưới dạng dịch vụ công nghệ thông tin (theo mô hình của <a href=\"http://vinades.vn/vi/download/van-ban-luat/Quyet-dinh-80-ve-thue-dich-vu-CNTT/\" target=\"_blank\">Quyết định số 80/2014/QĐ-TTg của Thủ tướng Chính phủ</a>) có thể hỗ trợ cho các trường, Phòng và Sở GD&amp;ĐT triển khai NukeViet ngay lập tức.<br  /><br  />Giải pháp cổng thông tin chuyên dùng cho phòng và Sở GD&amp;ĐT (NukeViet Edu Gate) có tích hợp website các trường (liên thông 3 cấp: trường - phòng - sở) cho phép tích hợp hàng ngàn website của các trường cùng nhiều dịch vụ khác trên cùng một hệ thống giúp tiết kiệm chi phí đầu tư, chi phí triển khai và bảo trì hệ thống bởi toàn bộ hệ thống được vận hành bằng một phần mềm duy nhất. Ngoài giải pháp cổng thông tin giáo dục tích hợp, Liên minh phần mềm nguồn mở giáo dục NukeViet cũng đang phát triển một số&nbsp;sản phẩm phần mềm dựa trên phần mềm nguồn mở NukeViet và sẽ sớm ra mắt trong thời gian tới.<div><br  />Hiện nay,&nbsp;NukeViet Edu Gate cũng&nbsp;đã được triển khai rộng rãi và nhận được sự ủng hộ của&nbsp;nhiều Phòng, Sở GD&amp;ĐT trên toàn quốc.&nbsp;Các phòng, sở GD&amp;ĐT quan tâm đến giải pháp NukeViet Edu Gate có thể truy cập&nbsp;<a href=\"http://edu.nukeviet.vn/\" target=\"_blank\">http://edu.nukeviet.vn</a>&nbsp;để tìm hiểu thêm hoặc liên hệ:<br  /><br  /><span style=\"font-size:14px;\"><strong>Liên minh phần mềm nguồn mở giáo dục NukeViet</strong></span><br  />Đại diện: <strong>Công ty cổ phần phát triển nguồn mở Việt Nam (VINADES.,JSC)</strong><br  /><strong>Địa chỉ</strong>: Phòng 2004 - Tòa nhà CT2 Nàng Hương, 583 Nguyễn Trãi, Hà Nội<br  /><strong>Email</strong>: contact@vinades.vn, Tel: 04-85872007, <strong>Fax</strong>: 04-35500914,<br  /><strong>Hotline</strong>: 0904762534 (Mr. Hùng), 0936226385 (Ms. Ngọc),&nbsp;<span style=\"color: rgb(38, 38, 38); font-family: arial, sans-serif; font-size: 13px; line-height: 16px;\">0904719186 (Mr. Hậu)</span><br  />Các Phòng GD&amp;ĐT, Sở GD&amp;ĐT có thể đăng ký tìm hiểu, tổ chức hội thảo, tập huấn, triển khai NukeViet trực tiếp tại đây: <a href=\"http://edu.nukeviet.vn/dangky.html\" target=\"_blank\">http://edu.nukeviet.vn/dangky.html</a><br  /><br  /><span style=\"font-size:16px;\"><strong>Tìm hiểu về phương thức chuyển đổi các hệ thống website cổng thông tin sang NukeViet theo mô hình tích hợp liên thông từ trưởng, lên Phòng, Sở GD&amp;ĐT:</strong></span><br  /><br  />Đối với các Phòng, Sở GD&amp;ĐT, trường Nầm non, tiểu học, THCS, THPT... chưa có website, Liên minh phần mềm nguồn mở giáo dục NukeViet sẽ hỗ trợ triển khai NukeViet theo mô hình cổng thông tin liên cấp như quy định tại <a href=\"http://vinades.vn/vi/download/van-ban-luat/Thong-tu-quy-dinh-ve-ve-to-chuc-hoat-dong-su-dung-thu-dien-tu/\" target=\"_blank\">thông tư số <strong>53/2012/TT-BGDĐT</strong> của Bộ GD&amp;ĐT</a> ban hành ngày 20-12-2012 quy định về quy định về về tổ chức hoạt động, sử dụng thư điện tử và cổng thông tin điện tử tại sở giáo dục và đào tạo, phòng giáo dục và đào tạo và các cơ sở GDMN, GDPT và GDTX.<br  /><br  />Trường hợp các đơn vị có website và đang sử dụng NukeViet theo dạng rời rạc thì việc chuyển đổi và tích hợp các website NukeViet rời rạc vào NukeViet Edu Gate của Phòng và Sở có thể thực hiện dễ dàng và giữ nguyên toàn bộ dữ liệu.<br  /><br  />Trường hợp các đơn vị có website và nhưng không sử dụng NukeViet cũng có thể chuyển đổi sang sử dụng NukeViet để hợp nhất vào hệ thống cổng thông tin giáo dục cấp Phòng, Sở. Tuy nhiên mức độ và tỉ lệ dữ liệu được chuyển đổi thành công sẽ phụ thuộc vào tình hình thực tế của từng website.</div></div>";
$sth_bodyhtml->bindParam(':id', $id, PDO::PARAM_INT);
$sth_bodyhtml->bindValue(':sourcetext', '', PDO::PARAM_STR);
$sth_bodyhtml->bindParam(':bodyhtml', $bodyhtml, PDO::PARAM_STR, strlen($bodyhtml));
$sth_bodyhtml->execute();
$bodytext = nv_news_get_bodytext($bodyhtml);
$sth_bodytext->bindParam(':id', $id, PDO::PARAM_INT);
$sth_bodytext->bindParam(':bodytext', $bodytext, PDO::PARAM_STR, strlen($bodytext));
$sth_bodytext->execute();

$id = 10;
$bodyhtml = "Cả hội trường như vỡ òa, rộn tiếng vỗ tay, tiếng cười nói chúc mừng các nhà khoa học, các nhóm tác giả đoạt Giải thưởng Nhân tài Đất Việt năm 2011. Năm thứ 7 liên tiếp, Giải thưởng đã phát hiện và tôn vinh nhiều tài năng của đất nước.<div align=\"center\"> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/01_b7d3f.jpg\" style=\"MARGIN: 5px\" width=\"450\" /></div><div align=\"center\"> <span style=\"FONT-SIZE: 10pt; FONT-FAMILY: Tahoma\">Sân khấu trước lễ trao giải.</span></div><div> &nbsp;</div><div align=\"center\"> &nbsp;</div><div align=\"left\"> Cơ cấu Giải thưởng của Nhân tài Đất Việt 2011 trong lĩnh vực CNTT bao gồm 2 hệ thống giải dành cho “Sản phẩm có tiềm năng ứng dụng” và “Sản phẩm đã ứng dụng rộng rãi trong thực tế”. Mỗi hệ thống giải sẽ có 1 giải Nhất, 1 giải Nhì và 1 giải Ba với trị giá giải thưởng tương đương là 100 triệu đồng, 50 triệu đồng và 30 triệu đồng cùng phần thưởng của các đơn vị tài trợ.</div><div align=\"center\"> &nbsp;</div><div align=\"center\"> <div align=\"center\"> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/03_f19bd.jpg\" width=\"350\" /></div> <div align=\"center\"> Nhiều tác giả, nhóm tác giả đến lễ trao giải từ rất sớm.</div></div><p> Giải thưởng Nhân tài Đất Việt 2011 trong lĩnh vực Khoa học Tự nhiên được gọi chính thức là Giải thưởng Khoa học Tự nhiên Việt Nam sẽ có tối đa 6 giải, trị giá 100 triệu đồng/giải dành cho các lĩnh vực: Toán học, Cơ học, Vật lý, Hoá học, Các khoa học về sự sống, Các khoa học về trái đất (gồm cả biển) và môi trường, và các lĩnh vực khoa học liên ngành hoặc đa ngành của hai hoặc nhiều ngành nói trên. Viện Khoa học và Công nghệ Việt Nam thành lập Hội đồng giám khảo gồm các nhà khoa học tự nhiên hàng đầu trong nước để thực hiện việc đánh giá và trao giải.</p><div> Sau thành công của việc trao Giải thưởng Nhân tài Đất Việt trong lĩnh vực Y dược năm 2010, Ban Tổ chức tiếp tục tìm kiếm những chủ nhân xứng đáng cho Giải thưởng này trong năm 2011.</div><div> &nbsp;</div><div align=\"center\"> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/07_78b85.jpg\" style=\"MARGIN: 5px\" width=\"450\" /></div><div align=\"center\"> <span style=\"FONT-SIZE: 10pt; FONT-FAMILY: Tahoma\">Nguyên Tổng Bí thư BCH TW Đảng Cộng sản Việt Nam Lê Khả Phiêu tới&nbsp;dự Lễ trao giải.</span></div><div> &nbsp;</div><div> 45 phút trước lễ trao giải, không khí tại Cung Văn hóa Hữu nghị Việt - Xô đã trở nên nhộn nhịp. Sảnh phía trước Cung gần như chật kín. Rất đông bạn trẻ yêu thích công nghệ thông tin, sinh viên các trường đại học đã đổ về đây, cùng với đó là những bó hoa tươi tắn sẽ được dành cho các tác giả, nhóm tác giả đoạt giải.</div><div> &nbsp;</div><div align=\"center\"> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/09_aef87.jpg\" style=\"MARGIN: 5px\" width=\"450\" /></div><div align=\"center\"> <span style=\"FONT-SIZE: 10pt; FONT-FAMILY: Tahoma\">Phó Chủ tịch nước CHXHCN Việt Nam Nguyễn Thị Doan.</span></div><div> &nbsp;</div><div> Các vị khách quý cũng đến từ rất sớm. Tới tham dự lễ trao giải năm nay có ông Lê Khả Phiêu, nguyên Tổng Bí thư BCH TW Đảng Cộng sản Việt Nam; bà Nguyễn Thị Doan, Phó Chủ tịch nước CHXHCN Việt Nam; ông Vũ Oanh, nguyên Ủy viên Bộ Chính trị, nguyên Chủ tịch Hội Khuyến học Việt Nam; ông Nguyễn Bắc Son, Bộ trưởng Bộ Thông tin và Truyền thông; ông Đặng Ngọc Tùng, Chủ tịch Tổng Liên đoàn lao động Việt Nam; ông Phạm Văn Linh, Phó trưởng ban Tuyên giáo Trung ương; ông Đỗ Trung Tá, Phái viên của Thủ tướng Chính phủ về CNTT, Chủ tịch Hội đồng Khoa học công nghệ quốc gia; ông Nguyễn Quốc Triệu, nguyên Bộ trưởng Bộ Y tế, Trưởng Ban Bảo vệ Sức khỏe TƯ; bà Cù Thị Hậu, Chủ tịch Hội người cao tuổi Việt Nam; ông Lê Doãn Hợp, nguyên Bộ trưởng Bộ Thông tin Truyền thông, Chủ tịch Hội thông tin truyền thông số…</div><div> &nbsp;</div><div align=\"center\"> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/08_ba46c.jpg\" style=\"MARGIN: 5px\" width=\"450\" /></div><div align=\"center\"> <span style=\"FONT-SIZE: 10pt; FONT-FAMILY: Tahoma\">Bộ trưởng Bộ Thông tin và Truyền thông Nguyễn Bắc Son.</span></div><div align=\"center\"> &nbsp;</div><div align=\"center\"> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/06_29592.jpg\" style=\"MARGIN: 5px\" width=\"450\" /></div><div align=\"center\"> <span style=\"FONT-SIZE: 10pt; FONT-FAMILY: Tahoma\">Giáo sư - Viện sỹ Nguyễn Văn Hiệu.</span></div><div align=\"center\"> &nbsp;</div><div align=\"center\"> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/04_051f2.jpg\" style=\"MARGIN: 5px\" width=\"450\" /></div><div align=\"center\"> <span style=\"FONT-SIZE: 10pt; FONT-FAMILY: Tahoma\">Nguyên Bộ trưởng Bộ Y tế Nguyễn Quốc Triệu.</span></div><div align=\"center\"> &nbsp;</div><div align=\"center\"> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/05_c7ea4.jpg\" style=\"MARGIN: 5px\" width=\"450\" /></div><div align=\"center\"> <span style=\"FONT-SIZE: 10pt; FONT-FAMILY: Tahoma\">Ông Vũ Oanh, nguyên Ủy viên Bộ Chính trị, nguyên Chủ tịch Hội Khuyến học Việt Nam.</span></div><p> Do tuổi cao, sức yếu hoặc bận công tác không đến tham dự lễ trao giải nhưng Đại tướng Võ Nguyên Giáp và Chủ tịch nước Trương Tấn Sang cũng gửi lẵng hoa đến chúc mừng lễ trao giải.</p><div> Đúng 20h, Lễ trao giải bắt đầu với bài hát “Nhân tài Đất Việt” do ca sỹ Thái Thùy Linh cùng ca sĩ nhí và nhóm múa biểu diễn. Các nhóm tác giả tham dự Giải thưởng năm 2011 và những tác giả của các năm trước từ từ bước ra sân khấu trong tiếng vỗ tay tán dương của khán giả.</div><div> &nbsp;</div><div align=\"center\"> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/12_74abf.jpg\" style=\"MARGIN: 5px\" width=\"450\" /></div><div align=\"center\"> &nbsp;</div><div align=\"center\"> <div> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/PHN15999_3e629.jpg\" style=\"MARGIN: 5px\" width=\"450\" /></div></div><div align=\"center\"> <span style=\"FONT-SIZE: 10pt; FONT-FAMILY: Tahoma\">Tiết mục mở màn Lễ trao giải.</span></div><p> Trước Lễ trao giải Giải thưởng Nhân tài Đất Việt năm 2011, Đại tướng Võ Nguyên Giáp, Chủ tịch danh dự Hội Khuyến học Việt Nam, đã gửi thư chúc mừng, khích lệ Ban tổ chức Giải thưởng cũng như các nhà khoa học, các tác giả tham dự.</p><blockquote> <p> <em><span style=\"FONT-STYLE: italic\">Hà Nội, ngày 16 tháng 11 năm 2011</span></em></p> <div> <em>Giải thưởng “Nhân tài đất Việt” do Hội Khuyến học Việt Nam khởi xướng đã bước vào năm thứ bảy (2005 - 2011) với ba lĩnh vực: Công nghệ thông tin, Khoa học tự nhiên và Y dược.</em></div></blockquote><div align=\"center\"> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/thuDaituong1_767f4.jpg\" style=\"MARGIN: 5px\" width=\"400\" /></div><div align=\"center\"> <span style=\"FONT-SIZE: 10pt; FONT-FAMILY: Tahoma\">Thư của Đại tướng Võ Nguyên Giáp gửi BTC Giải thưởng Nhân tài đất Việt.</span></div><blockquote> <p> <em>Tôi gửi lời chúc mừng các nhà khoa học và các thí sinh được nhận giải thưởng “Nhân tài đất Việt” năm nay.</em></p> <p> <em>Mong rằng, các sản phẩm và các công trình nghiên cứu được trao giải sẽ được tiếp tục hoàn thiện và được ứng dụng rộng rãi trong đời sống, đem lại hiệu quả kinh tế và xã hội thiết thực.</em></p> <p> <em>Nhân ngày “Nhà giáo Việt Nam”, chúc Hội Khuyến học Việt nam, chúc các thầy giáo và cô giáo, với tâm huyết và trí tuệ của mình, sẽ đóng góp xứng đáng vào công cuộc đổi mới căn bản và toàn diện nền giáo dục nước nhà, để cho nền giáo dục Việt Nam thực sự là cội nguồn của nguyên khí quốc gia, đảm bảo cho mọi nhân cách và tài năng đất Việt được vun đắp và phát huy vì sự trường tồn, sự phát triển tiến bộ và bền vững của đất nước trong thời đại toàn cầu hóa và hội nhập quốc tế.</em></p> <p> <em>Chào thân ái,</em></p> <p> <strong><em>Chủ tịch danh dự Hội Khuyến học Việt Nam</em></strong></p> <p> <strong><em>Đại tướng Võ Nguyên Giáp</em></strong></p></blockquote><p> Phát biểu khai mạc Lễ trao giải, Nhà báo Phạm Huy Hoàn, TBT báo điện tử Dân trí, Trưởng Ban tổ chức, bày tỏ lời cám ơn chân thành về những tình cảm cao đẹp và sự quan tâm chăm sóc của Đại tướng Võ Nguyên Giáp và Chủ tịch nước Trương Tấn Sang đã và đang dành cho Nhân tài Đất Việt.</p><div> Nhà báo Phạm Huy Hoàn nhấn mạnh, Giải thưởng Nhân tài Đất Việt suốt 7 năm qua đều nhận được sự quan tâm của các vị lãnh đạo Đảng, Nhà nước và của toàn xã hội. Tại Lễ trao giải, Ban tổ chức luôn có vinh dự được đón tiếp&nbsp;các vị lãnh đạo&nbsp; Đảng và Nhà nước đến dự và trực tiếp trao Giải thưởng.</div><div> &nbsp;</div><div align=\"center\"> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/15_4670c.jpg\" style=\"MARGIN: 5px\" width=\"450\" /></div><div align=\"center\"> <span style=\"FONT-SIZE: 10pt; FONT-FAMILY: Tahoma\">Trưởng Ban tổ chức Phạm Huy Hoàn phát biểu khai mạc buổi lễ.</span></div><p> Năm 2011, Giải thưởng có 3 lĩnh vực được xét trao giải là CNTT, Khoa học tự nhiên và Y dược. Lĩnh&nbsp; vực CNTT đã đón nhận 204 sản phẩm tham dự từ mọi miền đất nước và cả nước ngoài như thí sinh Nguyễn Thái Bình từ bang California - Hoa Kỳ và một thí sinh ở Pháp cũng đăng ký tham gia.</p><div> “Cùng với lĩnh vực CNTT, năm nay, Hội đồng khoa học của Viện khoa học và công nghệ Việt Nam và Hội đồng khoa học - Bộ Y tế tiếp tục giới thiệu những nhà khoa học xuất&nbsp; sắc, có công trình nghiên cứu đem lại nhiều lợi ích cho xã hội trong lĩnh vực khoa học tự nhiên và lĩnh vực y dược. Đó là những bác sĩ tài năng, những nhà khoa học mẫn tuệ, những người đang ngày đêm thầm lặng cống hiến trí tuệ sáng tạo của mình cho xã hội trong công cuộc xây dựng đất nước.” - nhà báo Phạm Huy Hoàn nói.</div><div> &nbsp;</div><div align=\"center\"> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/14_6e18f.jpg\" style=\"MARGIN: 5px\" width=\"450\" /></div><div align=\"center\"> <span style=\"FONT-SIZE: 10pt; FONT-FAMILY: Tahoma\">Nhà báo Phạm Huy Hoàn, TBT báo điện tử Dân trí, Trưởng BTC Giải thưởng và ông Phan Hoàng Đức, Phó TGĐ Tập đoàn VNPT nhận lẵng hoa chúc mừng của Đại tướng Võ Nguyên Giáp và Chủ tịch nước Trương Tấn Sang.</span></div><p> Cũng theo Trưởng Ban tổ chức Phạm Huy Hoàn, đến nay, vị Chủ tịch danh dự đầu tiên của Hội Khuyến học Việt Nam, Đại tướng Võ Nguyên Giáp, đã bước qua tuổi 100 nhưng vẫn luôn dõi theo và động viên từng bước phát triển của Giải thưởng Nhân tài Đất Việt. Đại tướng luôn quan tâm chăm sóc Giải thưởng ngay từ khi Giải thưởng&nbsp; mới ra đời cách đây 7 năm.</p><p> Trước lễ trao giải, Đại tướng Võ Nguyên Giáp đã gửi thư chúc mừng, động viên Ban tổ chức. Trong thư, Đại tướng viết: “Mong rằng, các sản phẩm và các công trình nghiên cứu được trao giải sẽ được tiếp tục hoàn thiện và được ứng dụng rộng rãi trong đời sống, đem lại hiệu quả kinh tế và xã hội thiết thực.</p><p> Sau phần khai mạc, cả hội trường hồi hội chờ đợi phút vinh danh các nhà khoa học và các tác giả, nhóm tác giả đoạt giải.</p><div> <span style=\"FONT-WEIGHT: bold\">* Giải thưởng Khoa học Tự nhiên Việt Nam </span>thuộc về 2 nhà khoa học GS.TS Trần Đức Thiệp và GS.TS Nguyễn Văn Đỗ - Viện Vật lý, Viện Khoa học công nghệ Việt Nam với công trình “Nghiên cứu cấu trúc hạt nhân và các phản ứng hạt nhân”.</div><div> &nbsp;</div><div align=\"center\"> <div> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/khtn_d4aae.jpg\" style=\"MARGIN: 5px\" width=\"450\" /></div></div><p> Hai nhà khoa học đã tiến hành thành công các nghiên cứu về phản ứng hạt nhân với nơtron, phản ứng quang hạt nhân, quang phân hạch và các phản ứng hạt nhân khác có cơ chế phức tạp trên các máy gia tốc như máy phát nơtron, Microtron và các máy gia tốc thẳng của Việt Nam và Quốc tế. Các nghiên cứu này đã góp phần làm sáng tỏ cấu trúc hạt nhân và cơ chế phản ứng hạt nhân, đồng thời cung cấp nhiều số liệu hạt nhân mới có giá trị cho Kho tàng số liệu hạt nhân.</p><p> GS.TS Trần Đức Thiệp và GS.TS Nguyễn Văn Đỗ đã khai thác hiệu quả hai máy gia tốc đầu tiên của Việt Nam là máy phát nơtron NA-3-C và Microtron MT-17 trong nghiên cứu cơ bản, nghiên cứu ứng dụng và đào tạo nhân lực. Trên cơ sở các thiết bị này, hai nhà khoa học đã tiến hành thành công những nghiên cứu cơ bản thực nghiệm đầu tiên về phản ứng hạt nhân ở Việt Nam; nghiên cứu và phát triển các phương pháp phân tích hạt nhân hiện đại và áp dụng thành công ở Việt Nam.</p><div> Bà Nguyễn Thị Doan, Phó Chủ tịch nước CHXHCNVN và Giáo sư - Viện sỹ Nguyễn Văn Hiệu trao giải thưởng cho 2 nhà khoa học.</div><div> &nbsp;</div><div align=\"center\"> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/khtn2_e2865.jpg\" style=\"MARGIN: 5px\" width=\"450\" /></div><div align=\"center\"> <span style=\"FONT-SIZE: 10pt; FONT-FAMILY: Tahoma\">Phó Chủ tịch nước CHXHCNVN Nguyễn Thị Doan và Giáo sư - Viện sỹ Nguyễn Văn Hiệu trao giải thưởng cho 2 nhà khoa học GS.TS Trần Đức Thiệp và GS.TS Nguyễn Văn Đỗ.</span></div><p> GS.VS Nguyễn Văn Hiệu chia sẻ: “Cách đây không lâu, Chính phủ đã ký quyết định xây dựng nhà máy điện hạt nhân trong điều kiện đất nước còn nhỏ bé, nghèo khó và vì thế việc đào tạo nhân lực là nhiệm vụ số 1 hiện nay. Rất may, Việt Nam có 2 nhà khoa học cực kỳ tâm huyết và nổi tiếng trong cả nước cũng như trên thế giới. Hội đồng khoa học chúng tôi muốn xướng tên 2 nhà khoa học này để Chính phủ huy động cùng phát triển xây dựng nhà máy điện hạt nhân.”</p><p> GS.VS Hiệu nhấn mạnh, mặc dù điều kiện làm việc của 2 nhà khoa học không được quan tâm, làm việc trên những máy móc cũ kỹ được mua từ năm 1992 nhưng 2 ông vẫn xay mê cống hiến hết mình cho lĩnh Khoa học tự nhiên Việt Nam.</p><p> <span style=\"FONT-WEIGHT: bold\">* Giải thưởng Nhân tài Đất Việt trong lĩnh vực Y Dược:</span> 2 giải</p><div> <span style=\"FONT-WEIGHT: bold\">1.</span> Nhóm nghiên cứu của Bệnh viện Hữu nghị Việt - Đức với công trình <span style=\"FONT-STYLE: italic\">“Nghiên cứu triển khai ghép gan, thận, tim lấy từ người cho chết não”</span>.</div><div> &nbsp;</div><div align=\"center\"> <div> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/y_3dca2.jpg\" style=\"MARGIN: 5px\" width=\"450\" /></div></div><div> &nbsp;</div><div> Tại bệnh viện Việt Đức, tháng 4/2011, các ca ghép tạng từ nguồn cho là người bệnh chết não được triển khai liên tục. Với 4 người cho chết não hiến tạng, bệnh viện đã ghép tim cho một trường hợp,&nbsp;2 người được ghép gan, 8 người được ghép thận, 2 người được ghép van tim và tất cả các ca ghép này đều thành công, người bệnh được ghép đã có một cuộc sống tốt hơn với tình trạng sức khỏe ổn định.</div><div> &nbsp;</div><div align=\"center\"> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/y2_cb5a1.jpg\" style=\"MARGIN: 5px\" width=\"450\" /></div><div align=\"center\"> <span style=\"FONT-SIZE: 10pt; FONT-FAMILY: Tahoma\">Nguyên Tổng Bí Ban chấp hành TW Đảng CSVN Lê Khả Phiêu và ông Vũ Văn Tiền, Chủ tịch Hội đồng quản trị Ngân hàng An Bình trao giải thưởng cho nhóm nghiên cứu của BV Hữu nghị Việt - Đức.</span></div><p> Công trong việc ghép tạng từ người cho chết não không chỉ thể hiện năng lực, trình độ, tay nghề của bác sĩ Việt Nam mà nó còn mang một ý nghĩa nhân văn to lớn, mang một thông điệp gửi đến những con người giàu lòng nhân ái với nghĩa cử cao đẹp đã hiến tạng để cứu sống những người bệnh khác.</p><p> <span style=\"FONT-WEIGHT: bold\">2.</span> Hội đồng ghép tim Bệnh viện Trung ương Huế với công trình nghiên cứu <span style=\"FONT-STYLE: italic\">“Triển khai ghép tim trên người lấy từ người cho chết não”</span>.</p><div> Đề tài được thực hiện dựa trên ca mổ ghép tim thành công lần đầu tiên ở Việt Nam của chính 100% đội ngũ y, bác sĩ của Bệnh viện Trung ương Huế đầu tháng 3/2011. Bệnh nhân được ghép tim thành công là anh Trần Mậu Đức (26 tuổi, ở phường Phú Hội, TP. Huế).</div><div> &nbsp;</div><div align=\"center\"> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/y3_7768c.jpg\" style=\"MARGIN: 5px\" width=\"450\" /></div><div align=\"center\"> <span style=\"FONT-SIZE: 10pt; FONT-FAMILY: Tahoma\">Hội đồng ghép tim BV Trung ương Huế nhận Giải thưởng Nhân tài Đất Việt.</span></div><p> Ghép tim từ người cho chết não đến người bị bệnh tim cần được ghép tim phải đảm bảo các yêu cầu: đánh giá chức năng các cơ quan; đánh giá tương hợp miễn dịch và phát hiện nguy cơ tiềm ẩn có thể xảy ra trong và sau khi ghép tim để từ đó có phương thức điều trị thích hợp. Có tới 30 xét nghiệm cận lâm sàng trung và cao cấp tiến hành cho cả người cho tim chết não và người sẽ nhận ghép tim tại hệ thống labo của bệnh viện.</p><p> ---------------------</p><p> <span style=\"FONT-WEIGHT: bold\">* Giải thưởng Nhân tài đất Việt Lĩnh vực Công nghệ thông tin.</span></p><p> <span style=\"FONT-STYLE: italic\">Hệ thống sản phẩm đã ứng dụng thực tế:</span></p><p> <span style=\"FONT-STYLE: italic\">Giải Nhất:</span> Không có.</p><p> <span style=\"FONT-STYLE: italic\">Giải Nhì:</span> Không có</p><p> <span style=\"FONT-STYLE: italic\">Giải Ba:</span> 3 giải, mỗi giải trị giá 30 triệu đồng.</p><div> <span style=\"FONT-WEIGHT: bold\">1.</span> <span style=\"FONT-STYLE: italic\">“Bộ cạc xử lý tín hiệu HDTV”</span> của nhóm HD Việt Nam.</div><div> &nbsp;</div><div align=\"center\"> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/hdtv_13b10.jpg\" style=\"MARGIN: 5px\" width=\"450\" /></div><div align=\"center\"> <span style=\"FONT-SIZE: 10pt; FONT-FAMILY: Tahoma\">Nhóm HDTV Việt Nam lên nhận giải.</span></div><p> Đây là bộ cạc xử lý tín hiệu HDTV đầu tiên tại Việt Nam đạt tiêu chuẩn OpenGear. Bộ thiết bị bao gồm 2 sản phẩm là cạc khuếch đại phân chia tín hiệu HD DA và cạc xử lý tín hiệu HD FX1. Nhờ bộ cạc này mà người sử dụng cũng có thể điều chỉnh mức âm thanh hoặc video để tín hiệu của kênh tuân theo mức chuẩn và không phụ thuộc vào chương trình đầu vào.</p><div> <span style=\"FONT-WEIGHT: bold; FONT-STYLE: italic\">2.</span> <span style=\"FONT-STYLE: italic\">“Mã nguồn mở NukeViet”</span> của nhóm tác giả Công ty cổ phần phát triển nguồn mở Việt Nam (VINADES.,JSC).</div><div> &nbsp;</div><div align=\"center\"> <div> <img _fl=\"\" align=\"middle\" alt=\"NukeViet nhận giải ba Nhân tài đất Việt 2011\" src=\"/uploads/news/nukeviet-nhantaidatviet2011.jpg\" style=\"margin: 5px; width: 450px; height: 301px;\" /></div></div><p> NukeViet là CMS mã nguồn mở đầu tiên của Việt Nam có quá trình phát triển lâu dài nhất, có lượng người sử dụng đông nhất. Hiện NukeViet cũng là một trong những mã nguồn mở chuyên nghiệp đầu tiên của Việt Nam, cơ quan chủ quản của NukeViet là VINADES.,JSC - đơn vị chịu trách nhiệm phát triển NukeViet và triển khai NukeViet thành các ứng dụng cụ thể cho doanh nghiệp.</p><div> <span style=\"FONT-WEIGHT: bold\">3.</span> <span style=\"FONT-STYLE: italic\">“Hệ thống ngôi nhà thông minh homeON”</span> của nhóm Smart home group.</div><div> &nbsp;</div><div align=\"center\"> <div> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/PHN16132_82014.jpg\" style=\"MARGIN: 5px\" width=\"450\" /></div></div><p> Sản phẩm là kết quả từ những nghiên cứu miệt mài nhằm xây dựng một ngôi nhà thông minh, một cuộc sống xanh với tiêu chí: An toàn, tiện nghi, sang trọng và tiết kiệm năng lượng, hưởng ứng lời kêu gọi tiết kiệm năng lượng của Chính phủ.&nbsp;</p><p> <strong><span style=\"FONT-STYLE: italic\">* Hệ thống sản phẩm có tiềm năng ứng dụng:</span></strong></p><p> <span style=\"FONT-STYLE: italic\">Giải Nhất: </span>Không có.</p><div> <span style=\"FONT-STYLE: italic\">Giải Nhì:</span> trị giá 50 triệu đồng: <span style=\"FONT-STYLE: italic\">“Dịch vụ Thông tin và Tri thức du lịch ứng dụng cộng nghệ ngữ nghĩa - iCompanion”</span> của nhóm tác giả SIG.</div><div> &nbsp;</div><div align=\"center\"> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/nhi_7eee0.jpg\" style=\"MARGIN: 5px\" width=\"450\" /></div><div align=\"center\"> <span style=\"FONT-SIZE: 10pt; FONT-FAMILY: Tahoma\">Nhóm tác giả SIG nhận giải Nhì Nhân tài đất Việt 2011 ở hệ thống sản phẩm có tiềm năng ứng dụng.</span></div><p> ICompanion là hệ thống thông tin đầu tiên ứng dụng công nghệ ngữ nghĩa trong lĩnh vực du lịch - với đặc thù khác biệt là cung cấp các dịch vụ tìm kiếm, gợi ý thông tin “thông minh” hơn, hướng người dùng và kết hợp khai thác các tính năng hiện đại của môi trường di động.</p><p> Đại diện nhóm SIG chia sẻ: “Tinh thần sáng tạo và lòng khát khao muốn được tạo ra các sản phẩm mới có khả năng ứng dụng cao trong thực tiễn luôn có trong lòng của những người trẻ Việt Nam. Cảm ơn ban tổ chức và những nhà tài trợ đã giúp chúng tôi có một sân chơi thú vị để khuyến khích và chắp cánh thực hiện ước mơ của mình. Xin cảm ơn trường ĐH Bách Khoa đã tạo ra một môi trường nghiên cứu và sáng tạo, gắn kết 5 thành viên trong nhóm.”</p><p> <span style=\"FONT-STYLE: italic\">Giải Ba:</span> 2 giải, mỗi giải trị giá 30 triệu đồng.</p><div> <span style=\"FONT-WEIGHT: bold\">1. </span><span style=\"FONT-STYLE: italic\">“Bộ điều khiển IPNET”</span> của nhóm IPNET</div><div> &nbsp;</div><div align=\"center\"> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/PHN16149_ed58d.jpg\" style=\"MARGIN: 5px\" width=\"450\" /></div><div align=\"center\"> <span style=\"FONT-SIZE: 10pt; FONT-FAMILY: Tahoma\">Nhà báo Phạm Huy Hoàn, Trưởng Ban Tổ chức Giải thưởng NTĐV, Tổng Biên tập báo điện tử Dân trí và ông Tạ Hữu Thanh - Phó TGĐ Jetstar Pacific trao giải cho nhóm IPNET.</span></div><p> Bằng cách sử dụng kiến thức thiên văn học để tính giờ mặt trời lặn và mọc tại vị trí cần chiếu sáng được sáng định bởi kinh độ, vĩ độ cao độ, hàng ngày sản phẩm sẽ tính lại thời gian cần bật/tắt đèn cho phù hợp với giờ mặt trời lặn/mọc.</p><div> <span style=\"FONT-WEIGHT: bold\">2.</span> <span style=\"FONT-STYLE: italic\">“Hệ thống lập kế hoạch xạ trị ung thư quản lý thông tin bệnh nhân trên web - LYNX”</span> của nhóm LYNX.</div><div> &nbsp;</div><div align=\"center\"> <div> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/3tiem-nang_32fee.jpg\" style=\"MARGIN: 5px\" width=\"450\" /></div></div><p> Đây là loại phần mềm hoàn toàn mới ở Việt Nam, là hệ thống lập kế hoạch và quản lý thông tin của bệnh nhân ung thư qua Internet (LYNX) dựa vào nền tảng Silverlight của Microsoft và kiến thức chuyên ngành Vật lý y học. LYNX giúp ích cho các nhà khoa học, bác sĩ, kỹ sư vật lý, bệnh nhân và mọi thành viên trong việc quản lý và theo dõi hệ thống xạ trị ung thư một cách tổng thể. LYNX có thể được sử dụng thông qua các thiết bị như máy tính cá nhân, máy tính bảng… và các trình duyệt Internet Explorer, Firefox, Chrome…</p><div> Chương trình trao giải đã được truyền hình trực tiếp trên VTV2 - Đài Truyền hình Việt Nam và tường thuật trực&nbsp;tuyến trên báo điện tử Dân trí từ 20h tối 20/11/2011.</div><div> &nbsp;</div><div align=\"center\"> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/NVH0545_c898e.jpg\" style=\"MARGIN: 5px\" width=\"450\" /></div><div align=\"center\"> &nbsp;</div><div align=\"center\"> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/NVH0560_c995c.jpg\" style=\"MARGIN: 5px\" width=\"450\" /></div><div align=\"center\"> &nbsp;</div><div align=\"center\"> <img _fl=\"\" align=\"middle\" src=\"http://dantri4.vcmedia.vn/xFKfMbJ7RTXgah5W1cc/File/2011/PHN16199_36a5c.jpg\" style=\"MARGIN: 5px\" width=\"450\" /></div><div align=\"center\"> &nbsp;</div><div align=\"center\"> <div align=\"center\"> <table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"> <tbody> <tr> <td> <div> <span style=\"FONT-WEIGHT: bold\"><span style=\"FONT-WEIGHT: normal; FONT-SIZE: 10pt; FONT-FAMILY: Tahoma\">Khởi xướng từ năm 2005, Giải thưởng Nhân tài Đất Việt đã phát hiện và tôn vinh nhiều tài năng trong lĩnh vực CNTT-TT, Khoa học tự nhiên và Y dược, trở thành một sân chơi bổ ích cho những người yêu thích CNTT. Mỗi năm, Giải thưởng ngày càng thu hút số lượng tác giả và sản phẩm tham gia đông đảo và nhận được sự quan tâm sâu sắc của lãnh đạo Đảng, Nhà nước cũng như công chúng.</span></span></div> <div> <span style=\"FONT-WEIGHT: bold\">&nbsp;</span></div> <div> <span style=\"FONT-WEIGHT: bold\"><span style=\"FONT-WEIGHT: normal; FONT-SIZE: 10pt; FONT-FAMILY: Tahoma\">Đối tượng tham gia Giải thưởng trong lĩnh vực CNTT là những người Việt Nam ở mọi lứa tuổi, đang sinh sống trong cũng như ngoài nước. Năm 2006, Giải thưởng có sự tham gia của thí sinh đến từ 8 nước trên thế giới và 40 tỉnh thành của Việt Nam. Từ năm 2009, Giải thưởng được mở rộng sang lĩnh vực Khoa học tự nhiên, và năm 2010 là lĩnh vực Y dược, vinh danh những nhà khoa học trong các lĩnh vực này.</span>&nbsp;</span></div> <div> <span style=\"FONT-WEIGHT: bold\">&nbsp;</span></div> </td> </tr> </tbody> </table> </div></div>";
$sth_bodyhtml->bindParam(':id', $id, PDO::PARAM_INT);
$sth_bodyhtml->bindValue(':sourcetext', '', PDO::PARAM_STR);
$sth_bodyhtml->bindParam(':bodyhtml', $bodyhtml, PDO::PARAM_STR, strlen($bodyhtml));
$sth_bodyhtml->execute();
$bodytext = nv_news_get_bodytext($bodyhtml);
$sth_bodytext->bindParam(':id', $id, PDO::PARAM_INT);
$sth_bodytext->bindParam(':bodytext', $bodytext, PDO::PARAM_STR, strlen($bodytext));
$sth_bodytext->execute();

// News: Sources
$sth = $db->prepare('INSERT INTO ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_sources (sourceid, title, link, logo, weight, add_time, edit_time) VALUES (?, ?, ?, ?, ?, ?, ?)');
$sth->execute(array(
    1,
    'Báo Hà Nội Mới',
    'http://hanoimoi.com.vn',
    '',
    1,
    1274989177,
    1274989177
));
$sth->execute(array(
    2,
    'VINADES.,JSC',
    'http://vinades.vn',
    '',
    2,
    1274989787,
    1274989787
));
$sth->execute(array(
    3,
    'Báo điện tử Dân Trí',
    'http://dantri.com.vn',
    '',
    4,
    1322685396,
    1322685396
));
$sth->execute(array(
    4,
    'Bộ Thông tin và Truyền thông',
    'http://http://mic.gov.vn',
    '',
    5,
    1445309676,
    1445309676
));

// Topic
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_topics VALUES (1, 'NukeViet 4', 'NukeViet-4', '', 'NukeViet 4', 1, 'NukeViet 4', 1445396011, 1445396011)");

//
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_block_cat (bid, adddefault, numbers,title, alias, image, description, weight, keywords, add_time, edit_time) VALUES (1, 0, 4,'Tin tiêu điểm', 'Tin-tieu-diem', '', 'Tin tiêu điểm', 1, '', 1279945710, 1279956943)");
$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_block_cat (bid, adddefault, numbers,title, alias, image, description, weight, keywords, add_time, edit_time) VALUES (2, 1, 4, 'Tin mới nhất', 'Tin-moi-nhat', '', 'Tin mới nhất', 2, '', 1279945725, 1279956445)");

$db->query('INSERT INTO ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_block VALUES (1, 1, 1)');
$db->query('INSERT INTO ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_block VALUES (2, 14, 4)');
$db->query('INSERT INTO ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_block VALUES (2, 12, 6)');
$db->query('INSERT INTO ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_block VALUES (2, 6, 9)');
$db->query('INSERT INTO ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_block VALUES (2, 13, 5)');
$db->query('INSERT INTO ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_block VALUES (2, 11, 7)');
$db->query('INSERT INTO ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_block VALUES (2, 1, 8)');
$db->query('INSERT INTO ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_block VALUES (2, 15, 3)');
$db->query('INSERT INTO ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_block VALUES (2, 16, 2)');
$db->query('INSERT INTO ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_block VALUES (2, 17, 1)');

$sth = $db->prepare('INSERT INTO ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_tags (tid, numnews, alias, image, description, keywords) VALUES (?, ?, ?, ?, ?, ?)');
$sth->execute(array(
    1,
    1,
    'nguồn-mở',
    '',
    '',
    'nguồn mở'
));
$sth->execute(array(
    2,
    1,
    'quen-thuộc',
    '',
    '',
    'quen thuộc'
));
$sth->execute(array(
    3,
    1,
    'cộng-đồng',
    '',
    '',
    'cộng đồng'
));
$sth->execute(array(
    4,
    1,
    'việt-nam',
    '',
    '',
    'việt nam'
));
$sth->execute(array(
    5,
    1,
    'hoạt-động',
    '',
    '',
    'hoạt động'
));
$sth->execute(array(
    6,
    1,
    'tin-tức',
    '',
    '',
    'tin tức'
));
$sth->execute(array(
    7,
    1,
    'thương-mại-điện',
    '',
    '',
    'thương mại điện'
));
$sth->execute(array(
    8,
    1,
    'điện-tử',
    '',
    '',
    'điện tử'
));
$sth->execute(array(
    9,
    3,
    'nukeviet',
    '',
    '',
    'nukeviet'
));
$sth->execute(array(
    10,
    1,
    'vinades',
    '',
    '',
    'vinades'
));
$sth->execute(array(
    11,
    1,
    'lập-trình-viên',
    '',
    '',
    'lập trình viên'
));
$sth->execute(array(
    12,
    1,
    'chuyên-viên-đồ-họa',
    '',
    '',
    'chuyên viên đồ họa'
));
$sth->execute(array(
    13,
    1,
    'php',
    '',
    '',
    'php'
));
$sth->execute(array(
    14,
    1,
    'mysql',
    '',
    '',
    'mysql'
));
$sth->execute(array(
    15,
    1,
    'nhân-tài-đất-việt-2011',
    '',
    '',
    'nhân tài đất việt 2011'
));
$sth->execute(array(
    16,
    1,
    'mã-nguồn-mở',
    '',
    '',
    'mã nguồn mở'
));

$sth = $db->prepare("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_tags_id (id, tid, keyword) VALUES (?, ?, ?)");
$sth->execute(array(
    1,
    1,
    'nguồn mở'
));
$sth->execute(array(
    1,
    2,
    'quen thuộc'
));
$sth->execute(array(
    1,
    3,
    'cộng đồng'
));
$sth->execute(array(
    1,
    4,
    'việt nam'
));
$sth->execute(array(
    1,
    5,
    'hoạt động'
));
$sth->execute(array(
    1,
    6,
    'tin tức'
));
$sth->execute(array(
    1,
    7,
    'thương mại điện'
));
$sth->execute(array(
    1,
    8,
    'điện tử'
));
$sth->execute(array(
    1,
    9,
    'nukeviet'
));
$sth->execute(array(
    7,
    10,
    'vinades'
));
$sth->execute(array(
    7,
    9,
    'nukeviet'
));
$sth->execute(array(
    7,
    11,
    'lập trình viên'
));
$sth->execute(array(
    7,
    12,
    'chuyên viên đồ họa'
));
$sth->execute(array(
    7,
    13,
    'php'
));
$sth->execute(array(
    7,
    14,
    'mysql'
));
$sth->execute(array(
    10,
    15,
    'Nhân tài đất Việt 2011'
));
$sth->execute(array(
    10,
    16,
    'mã nguồn mở'
));
$sth->execute(array(
    10,
    9,
    'nukeviet'
));

$copyright = 'Chú ý: Việc đăng lại bài viết trên ở website hoặc các phương tiện truyền thông khác mà không ghi rõ nguồn http://nukeviet.vn là vi phạm bản quyền';

$db->query("UPDATE " . $db_config['prefix'] . "_config SET config_value = " . $db->quote($copyright) . " WHERE module = " . $db->quote($module_name) . " AND config_name = 'copyright' AND lang=" . $db->quote($lang));

$result = $db->query('SELECT catid FROM ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_cat ORDER BY sort ASC');
while (list ($catid_i) = $result->fetch(3)) {
    $db->exec('CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_' . $catid_i . ' LIKE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_rows');
}

$result = $db->query('SELECT id, listcatid FROM ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_rows ORDER BY id ASC');

while (list ($id, $listcatid) = $result->fetch(3)) {
    $arr_catid = explode(',', $listcatid);
    foreach ($arr_catid as $catid) {
        $db->query('INSERT INTO ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_' . $catid . ' SELECT * FROM ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_rows WHERE id=' . $id);
    }
}
$result->closeCursor();