<?php
namespace Home\Controller;

use Think\Controller;
use Think\Model;
use Home\Model\TbUserModel;
class UserController extends Controller{
    private $userModel;
    
    function __construct(){
        parent::__construct();
//         $this->userModel = new Model("tb_user");  //普通常用方法实例化
        $this->userModel = M("tb_user");  //M方法实例化 推荐，创建父类

        
//         $this->userModel = D("TbUser");           //D方法实例化，创建子类
//         $this->userModel = new TbUserModel();       //
    }
    
    /**
     * 异步回填用户信息
     */
    public function loadThisUser($uid){
        $data = $this->userModel->find($uid);
        $this->ajaxReturn($data);
    }
    /**
     * 同步修改或新增用户
     */
    public function AsaveOrUpdateUser(){
        $data = $this->userModel->create();
        if ($data["uid"]>0){
            $sql = $this->userModel->where('uid=%d',$data["uid"])->save();
            echo $sql;
        }else {
            $this->userModel->field('userName,tureName,userSex,userPass,userPhone')->add($data);
        }
//         $this->AloadUserList();
    }
    /**
     * 同步 删除用户
     */
    public function AdeleteUser(){
        foreach ($rows as $u){
            $this->userModel->delete($u['uid']);
        }
        $this->loadUserList();
    }
    /**
     * 同步加载用户列表
     */
    public function AloadUserList($pageNo=1,$pageSize=10){
        $users = $this->userModel->field('u.*,d.deptName,d.did ddid')->table('tb_user u,tb_dept d')
        ->where('d.did=u.did')->page($pageNo,$pageSize)->select();
        //         $total = $this->userModel->getField('count(*)');//查询总数
        $total = $this->userModel->count();//查询总数
    
        $data = array('rows'=>$users,'total'=>$total,'pageNo'=>$pageNo,'pageSize'=>$pageSize);
        
        $this->assign("data",$data);
        $this->display('userManagement');
    }
    
    public function textView(){
       $_SESSION["rue"] = 1;
        //普通变量
        $this->assign("aaa",time());
        $this->assign("bbb","中国");

        $this->assign("sex",1);
        //数组变量
        $arr = array("无连接","豆腐干","与规范","各个00","设计天天","二极管VR","我一个人带着");//索引数组
//         $this->assign("ccc",["无连接","豆腐干","与规范"]);
        $this->assign("ccc",$arr);
        
        $data['name'] = 'ThinkPHP'; $data['email'] = 'thinkphp@qq.com'; //关联数组
        $this->assign('ddd',$data);
        //对象变量
        $aobj = new \stdClass();
        $aobj->name = "孔二飞";
        $aobj->class = "U32";
        $this->assign("aobj",$aobj);
        $this->display();      //不加theme表示使用默认模板主题
    }
    
    
    /**
     * 用户注册
     */
    function reg($userName,$userPass,$trueName){
        $userName = $_POST["userName"];
        $userPass = $_POST["userPass"];
        $trueName = $_POST["trueName"];

        $host = $_SERVER["HTTP_HOST"];
        $coun = $this->userModel->where("userName='$userName'")->select();
        if (count($coun)>0){
            $_SESSION["errormessing"] = "该用户已被注册！";//错误信息
            header("location:http://".$host."/tp/Application/Home/View/reg.php");
        }else{
            $this->userModel->
            data(array("userName"=>$userName,"userPass"=>$userPass,"tureName"=>$trueName))->add();
            header("location:http://".$host."/tp/Application/Home/View/login.php");
        }
    }
    
    /**
     * 用户登录
     */
    function login($userName,$userPass){
        
//         $userName = $_POST["userName"];
//         $userPass = $_POST["userPass"];
        
        $users = $this->userModel->where("userName='$userName'")->select();
        $host = $_SERVER["HTTP_HOST"];
     if (count($users) < 1){
        $_SESSION["errormessing"] = "用户名不存在！";//错误信息
        header("location:http://".$host."/tp/Application/Home/View/login.php");
        }else {
            $user = $users[0];
            if ($user['userpass'] == $userPass){
                $_SESSION["loginUser"] = $user;//当前登录用户
                $_SESSION["myuid"] = $user['uid'];//当前登录用户ID
                $_SESSION["myNo"] = $user['username'];//当前登录用户工号
                $_SESSION["myName"] = $user['turename'];//当前登录用户姓名
                
                //查询跟踪进度
                $trackProgress = $this->userModel->table('tb_contact')->select();
                $_SESSION["trackProgress"] = $trackProgress;//所有跟踪进度
                
                //查询渠道
                $channels = $this->userModel->table('tb_channel')->where('isshow =1')->select();
                $_SESSION["channels"] = $channels;//所有渠道
                
                //查询产品
                $products = $this->userModel->table('tb_product')->select();
                $_SESSION["products"] = $products;//所有产品
                
                //查询所有用户
                $allusers = $this->userModel->table('tb_user')->where('isdelete=1')->select();
                $_SESSION["allusers"] = $allusers;//所有用户
                
//                 $depts = $this->MenuModel->loadAllDeptList();//查询所有部门以及人数
//                 $_SESSION["depts"] = $depts;//所有部门以及人数

                $myrole = $this->userModel
                ->field('r.rid ,r.roleName')->table('tb_role r,tb_user u,tb_userrole ur')
                ->where('r.rid=ur.rid and u.uid=ur.uid and u.uid='.$user['uid'])->select()[0]['rid'];
                $_SESSION["myrole"] = $myrole;//我的角色 id name 
               
//                 $myDepts = $this->UserModel->loadMyDeptList();//查询我的部门
//                 $_SESSION["myDepts"] = $myDepts;//我的部门

                //查询显示菜单
                $menus = $this->userModel
                ->field('m.*')->table('tb_menu m ,tb_rolemenu rm ,tb_role r')
                ->where('m.mid=rm.mid and r.rid=rm.rid and r.rid='.$myrole)->select();
                $_SESSION["menus"] = $menus;//当前登录用户能看到的菜单
                
//                 $myDeptsUser = $this->UserModel->loadMyDeptAllUser();//查询本部所有的人
//                 $_SESSION["myDeptsUser"] = $myDeptsUser;//本部所有的人
//                 $myDeptUsers = $this->UserModel->loadMyDept();//查询本部门除自己以外的人
//                 $_SESSION["myDeptUsers"] = $myDeptUsers;//本部门除自己以外的人
                $this->assign("menus",$menus);
                $this->display('welcome');      //不加theme表示使用默认模板主题
//                 redirect("http://".$host."/tp/Application/Home/View/welcome.php");//重定向  (重点)
//                 header("location:http://".$host."/tp/Application/Home/View/welcome.php");
            }else {
                $_SESSION["errormessing"] = "密码错误！";//错误信息
//                 $this->error("密码错误！");
                header("location:http://".$host."/tp/Application/Home/View/login.php");
            }
        }
    }
    
    /**
     * 加载用户列表
     */
    public function loadUserList($pageNo=1,$pageSize=10){
        $users = $this->userModel->field('u.*,d.deptName,d.did ddid')->table('tb_user u,tb_dept d')
        ->where('u.did=d.did')->page($pageNo,$pageSize)->select();
//         $total = $this->userModel->getField('count(*)');//查询总数
        $total = $this->userModel->count();//查询总数
        
        $data = array('rows'=>$users,'total'=>$total,'pageNo'=>$pageNo,'pageSize'=>$pageSize);
        $this->ajaxReturn($data);
    }
    
    
    /**
     * 修改或新增用户
     */
    public function saveOrUpdateUser(){
        $data = $this->userModel->create();
        if ($data["uid"]>0){
            $this->userModel->where('uid=%d',$data["uid"])->save();
        }else {
            $this->userModel->field('userName,tureName,userSex,userPass,userPhone,did')->add($data);
        }
        $this->loadUserList();
    }
    
    public function deleteUser($rows){
        foreach ($rows as $u){
            $this->userModel->delete($u['uid']);
        }
        $this->loadUserList();
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}

?>