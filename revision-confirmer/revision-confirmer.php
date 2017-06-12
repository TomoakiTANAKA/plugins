<?php
/*
  Plugin Name: RevisionConfirmer
  Plugin URI:
  Description: リビジョンを元に戻す機能に、確認ダイアログを付与する
  Version: 1.0.0
  Author: tanakanoanchan
  Author URI: https://github.com/TomoakiTANAKA/plugins
  License: GPLv2
 */

add_action('init', 'RevisionConfirmer::init');

class RevisionConfirmer
{
    static function init()
    {
        return new self();
    }

    function __construct()
    {
        if (is_user_logged_in()) {
            // リビジョン画面のバリデーション
            add_action('admin_head-revision.php', [$this, 'validate_revision'], 8);
        }
    }

    /** リビジョンを元に戻すボタンにvalidationを付与する */
    function validate_revision()
    {
        // メモ
        // revisionを戻すボタンは、ajax通信しているため、イベントをバインドする際に、親要素を軸にする必要がある
        // また、イベントはbackborne.jsで行っているためキャンセル方法が特殊な点に注意

        $script =
<<<EOT
<script>
    jQuery(window).load(function() {
        jQuery('.revisions-meta').on('click','input.restore-revision', function(e) {
            if(!window.confirm("リビジョンが変更されます。よろしいですか？")) {
                // TODO : キャンセル処理
        })
    });
</script>
EOT;
        echo $script;
    }
}
