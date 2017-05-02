<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class LoadController extends Controller{
    private $loadModel;
    
    function __construct(){
        $this->loadModel = new Model("tb_customer");
    }
    
   
    /**
     * 加载所有渠道列表
     */
    public function loadAllChannelList(){
        $channels = $this->loadModel->table('tb_channel')->select();
        $this->ajaxReturn($channels);
    }
    
    
    /**
     *
     * 加载所有咨询产品下拉列表
     */
    public function loadAllProductList(){
        $products = $this->loadModel->table('tb_product')->select();
        $this->ajaxReturn($products);
    }
    
    /**
     * 加载部门列表
     */
    public function loadAllDeptList(){
        $sql = $this->loadModel->field('count(u.uid)')->table('tb_dept d1,tb_user u')
        ->where('d1.did=u.did and d1.did=d.did')->group('d1.did')->select(false);
        $depts = $this->loadModel->field('d.did,d.deptName,ifnull(('.$sql.'),0) number')->table('tb_dept d')->select();
        $_SESSION["depts"] = $depts;
        $this->ajaxReturn($depts);
    }
    
    /**
     * 加载所有菜单列表
     */
    public function loadAllMenuList($pageNo=1,$pageSize=10){
        $total = $this->loadModel->table(tb_menu)->count();//查询总数
        $sql = $this->loadModel->field('m1.menuName')->table('tb_menu m1')
        ->where('m.parentID=m1.mid')->select(false);//子查询
        
        $menus = $this->loadModel->field('m.*,('.$sql.') parintname')->table('tb_menu m')
        ->page($pageNo,$pageSize)->select();
        
        $parentIDs = $this->loadModel->field('mid,menuName')->table('tb_menu')->select();
        $_SESSION["parentID"] = $parentIDs;//加载菜单名
        $data = array('rows'=>$menus,'total'=>$total,'pageNo'=>$pageNo,'pageSize'=>$pageSize);
        $this->ajaxReturn($data);
    }
    
    
    
    /**
     * 加载日志列表
     */
    public function loadLogList($pageNo=1,$pageSize=10,$operation="",$userid="",$sT="",$eT=""){
        $parma = " l.uid=u.uid and 1=1 ";
        $arr = array();
        if ($operation>0){
            $parma .= " and l.operation='%d'";
            $arr[] = "$operation";
        }
        if ($userid>0){
            $parma .= " and l.uid='%d'";
            $arr[] = "$userid";
        }
        if ($sT != null && $sT != "" && $eT != null && $eT != ""){
            $parma .= " and  l.time between '%s' and '%s'";
            $arr[] = "$sT";
            $arr[] = "$eT";
        }
        $total = $this->loadModel->table('tb_log l,tb_user u')
        ->where($parma,$arr)->count();//查询总数
        $loads = $this->loadModel->field('l.*,u.tureName')
        ->table('tb_log l,tb_user u')->page($pageNo,$pageSize)
        ->order('l.lid desc')
        ->where($parma,$arr)->select();
        $data = array('rows'=>$loads,'total'=>$total,'pageNo'=>$pageNo,'pageSize'=>$pageSize);
        $this->ajaxReturn($data);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}

?>