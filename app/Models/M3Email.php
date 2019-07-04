<?php
/**
 * Created by PhpStorm.
 * User: HuaRun
 * Date: 2018/10/25
 * Time: 20:37
 */

namespace App\Models;


class M3Email
{
    public $from; //发件人邮箱
    public $to; //收件人邮箱
    public $cc;  //抄送
    public $attach; //附件
    public $subject; //主题
    public $content; //内容
}