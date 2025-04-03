<?php


namespace common\components;
use common\models\auth\AuthItem;
use common\models\auth\AuthItemChild;
use common\models\auth\AuthAssignment;
/**
 * Description of RBAC
 *
 * @author OneLab
 */
class RBAC {
    //put your code here
    public function CreateModulePermissions($ModuleName){
        $AuthItem= AuthItem::find()->where("name='/".$ModuleName."/*'")->one();
        if(!$AuthItem){// Create Only if permission does not exits
            //Create Route
            $AuthItem=new AuthItem();
            $AuthItem->name="/".strtolower($ModuleName)."/*";
            $AuthItem->type=2;
            $AuthItem->save();
            //create permissions
            $AuthItem2=new AuthItem();
            $AuthItem2->name="access-".strtolower($ModuleName);
            $AuthItem2->description="This permission allow user to access $ModuleName module";
            $AuthItem2->type=2;
            $AuthItem2->save();
            $AuthItemChild=new AuthItemChild();
            $AuthItemChild->parent="access-".strtolower($ModuleName);
            $AuthItemChild->child="/".strtolower($ModuleName)."/*";
            $AuthItemChild->save();
        }
    }
    public function CreateSubModulePermissions($SubModuleName, $Url){
        $Url=$Url."/*";//route: /options/configurations/denominations/*
        //$SubModuleName: Denominations
        $AuthItem= AuthItem::find()->where(["name"=>$Url])->one();
        if(!$AuthItem){// Create Only if permission does not exits
            //Create Route
            $AuthItem=new AuthItem();
            $AuthItem->name=$Url;
            $AuthItem->type=2;
            $AuthItem->save();
        }
            //create permissions
            $sName= "access-".str_replace(" ", "-", strtolower(trim($SubModuleName)));//access-denominations
            $AuthItem2=AuthItem::find()->where(['name'=>$sName])->one();
            if(!$AuthItem2){
                 $AuthItem2=new AuthItem();
            }
            $AuthItem2->name=$sName;
            $AuthItem2->description="This permission allow user to access $SubModuleName Submodule";
            $AuthItem2->type=2;
            $AuthItem2->save();
            $AuthItemChild=AuthItemChild::find()->where(['child'=>$sName])->one();
            if(!$AuthItemChild){
                $AuthItemChild=new AuthItemChild();
            } 
            $AuthItemChild->parent=$sName;
            $AuthItemChild->child=$Url;
            $AuthItemChild->save();
       
            //throw new \BadFunctionCallException('Failed to generate permissions.');
            return true;
       
    }
    
}
