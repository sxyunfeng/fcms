<?php
namespace apps\admin\libraries;

use apps\admin\models\PriGroups;
use apps\admin\models\PriPris;
use apps\admin\models\PriRoles;
use enums\SystemEnums;
use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Resource;
use Phalcon\Acl\Role;

/**
 * AdminAcl
 *
 * @author hfc
 */
trait  AdminAcl
{
    /**
    * 设置访问控制
    * int $groupId 分组id
    */
    protected function setAcl( $groupId = 0 )
    {
        if( !$groupId )
        {
            return;
        }
        $group = PriGroups::findFirst( $groupId );
        $roles = $pris =  array();
        //组所包含的角色
        foreach( $group->priGroupsRoles as $groupRoles )
        {
            $roles[] = $groupRoles->roleid;
        }
        //角色包含权限
        foreach( $roles as $roleId )
        {
            $role = PriRoles::findFirst( $roleId );
            foreach( $role->priRolesPris as $rolePris )
            {
                $pris[ $rolePris->priPris->id ] = $rolePris->priPris->toArray(); //此处可去重
            }
        }

        $allowRes = $this->getResource( $pris ); //允许的资源
        $roleName = 'group' . $groupId; //和分组id相关
        $acl = $this->safeCache->get( 'aclList' );
                
        if( ! $acl ) //不存在acl
        {
            $acl = new AclList();
            $acl->setDefaultAction( Acl::ALLOW ); //不受控的操作允许访问
        }
        
        $role = new Role( $roleName );
        $acl->addRole( $role );

        $allRes = $this->getAllRes();
        foreach( $allRes as $res => $actions )  //所有资源都要拒绝
        {
            $acl->addResource( new  Resource( $res ), $actions );
            $acl->deny( $roleName, $res, $actions );
        }
        
        foreach( $allowRes as $res => $actions ) //允许的资源
        {
            if( isset( $allRes[ $res ]))
            {
                $diff = array_diff( $actions, $allRes[ $res ] ); //必须在allRes有一份
                if( !$diff )
                {
                    $acl->allow( $roleName, $res, $actions );
                }
                else
                {
                    foreach( $actions as $key => $item )
                    {
                        if( in_array( $item, $diff ))
                        {
                            unset( $actions[ $key ]);
                        }
                    }
                }
            }
        }
        $acl->allow( $roleName, 'index', 'index' ); //默认增加admin/index/index
        
        $this->fCache->save( 'aclList' . $groupId, serialize( $acl ) );
        $this->safeCache->save( 'aclList' . $groupId,  $acl  );
        return true;
    }
    
    /**
     * 获得所有的资源项
     */
    private function getAllRes()
    {
        $allRes = $this->safeCache->get( 'allResource' );
        if( ! $allRes )
        {
            $where = 'delsign=' . SystemEnums::DELSIGN_NO . ' and apid != 0 and ('
                . 'type=' . SystemEnums::PRI_ACTION . ' or type=' . SystemEnums::PRI_MENU  . ')';
            $allPris = PriPris::find( [ $where,'columns' => 'id,src,apid' ] )->toArray();
            $allRes = $this->getResource( $allPris );
            $this->safeCache->save( 'allResource', $allRes );
        }
        return $allRes;
    }
    
    /**
     * 根据权限项获得 资源 （控制器， 操作）
     * param array $pris 权限项
     * return array $resource 资源 键是控制器，值是操作
     */
    protected function getResource( $pris = array())
    {
        //读所有的控制器
        $allControllers = $this->safeCache->get( 'allControllers' );
        if( ! $allControllers )
        {
            $result = PriPris::find( [ 'delsign=' . SystemEnums::DELSIGN_NO . ' and type=' .SystemEnums::PRI_CONTROLLER, 'columns' => 'id, src' ] )->toArray();
            foreach( $result as $item )
            {
                $allControllers[ $item[ 'id'] ] = $item;
            }
            $this->safeCache->save( 'allControllers', $allControllers );
        }
        
        $resource = array();
        foreach( $pris as $pri )
        {
            $action = $pri[ 'src' ];
            if(  isset( $allControllers[ $pri[ 'apid']]['src']))
            {
                $controller = $allControllers[ $pri[ 'apid']  ][ 'src' ];
                $resource[ $controller ][] = $action;
            }
        }
        return $resource;
    }
    
    
}
