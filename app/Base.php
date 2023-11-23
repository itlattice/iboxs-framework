<?php
declare (strict_types = 1);

namespace app;

use iboxs\App;
use iboxs\convert\ControllerAction;
use iboxs\convert\Convert;
use iboxs\exception\ValidateException;
use iboxs\PostData;
use iboxs\PostHeader;
use iboxs\Validate;

/**
 * 控制器基础类
 */
abstract class Base
{
    use Convert,ControllerAction;
    /**
     * Request实例
     * @var \iboxs\Request
     */
    protected $request;

    /**
     * 应用实例
     * @var \iboxs\App
     */
    protected $app;

    /**
     * 是否批量验证
     * @var bool
     */
    protected $batchValidate = false;

    /**
     * @var \iboxs\PostData 请求数据
     */
    protected $postdata;

    /**
     * @var \iboxs\PostHeader 请求头信息
     */
    protected $postheader;

    /**
     * 控制器中间件
     * @var array
     */
    protected $middleware = [];

    /**
     * 构造方法
     * @access public
     * @param  App  $app  应用对象
     */
    public function __construct(App $app)
    {
        $this->app     = $app;
        $this->request = request();
        $this->postdata=new PostData();
        $this->postheader=new PostHeader();
        // 控制器初始化
        $this->initialize();
    }

    // 初始化
    protected function initialize()
    {}

    /**
     * 验证数据
     * @access protected
     * @param  array        $data     数据
     * @param  string|array $validate 验证器名或者验证规则数组
     * @param  array        $message  提示信息
     * @param  bool         $batch    是否批量验证
     * @return array|string|true
     * @throws ValidateException
     */
    protected function validate(array $data, $validate, array $message = [], bool $batch = false)
    {
        if (is_array($validate)) {
            $v = new Validate();
            $v->rule($validate);
        } else {
            if (strpos($validate, '.')) {
                // 支持场景
                [$validate, $scene] = explode('.', $validate);
            }
            $class = false !== strpos($validate, '\\') ? $validate : $this->app->parseClass('validate', $validate);
            $v     = new $class();
            if (!empty($scene)) {
                $v->scene($scene);
            }
        }

        $v->message($message);

        // 是否批量验证
        if ($batch || $this->batchValidate) {
            $v->batch(true);
        }

        return $v->failException(true)->check($data);
    }

}
