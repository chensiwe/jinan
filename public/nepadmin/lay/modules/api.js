//请求URL
layui.define([], function (exports) {
    exports('api', {
        login: 'users/login',

        getMenu: 'auths/get_menu',
        getGoods: 'json/goods.js',

        // 权限管理
        getAuthList: 'auths/get_tree_list',
        saveAuthList: 'auths/save_tree_list',
        addAuth: 'auths/add',
        getAllAuth: 'auths/getAll',

        // 角色管理
        addRole: 'roles/add',
        getAllRole: 'roles/getAll',
        getRoleInfo: 'roles/getOne',
        ediRole: 'roles/update',
        delRole: 'roles/delete',

        // 系统管理
        clearCache: 'system/clearCache',
        showCache: 'system/showCache',

        // 用户管理
        getUserlist: 'users/getAll',
        addUser: 'users/add',

        //供应商管理
        getsupplylist:'supply/getList',
        addSupply:'supply/add',

        //商品分类管理
        getcatelist:'productcate/getList',
        addcate:'productcate/add',
        editcate:'Productcate/update',
        addproduct:'product/add',
        getproducts:'product/getList',
        delproduct:'product/delete',
        editproduct:'Product/edit',
        getthink:'Think/getList',
        //借贷列表
        getborrows:'borrow/getList',
        addborrow:'borrow/add',

        getbanks:'bank/getList',
        getxds:'xd/getList',
        getmjs:'mj/getList',
        getcards:'card/getList',
        getways:'ways/getList',
        getcustypes:'Custype/getList',
        delutype:'Custype/delete',
        addusertype:'Custype/add',
        readreminder:'borrow/setread',
        addbank:'bank/add',
        delbank:'bank/delete',
        addmj:'mj/add',
        delmj:'mj/delete',
        delcard:'card/delete',
        addcard:'card/add',
        addfrom:'from/add',
        getfrom:'from/getList',
        delfrom:'from/delete',
        addway:'ways/add',
        getways:'ways/getList',
        delway:'ways/delete',
        delsupply:'supply/delete',
        getsupplytypes:'supplyType/getList',
        exportcsv:'borrow/exportCsv',
        getgbs:'Gb/getList',
        addgb:'Gb/add',
        delgb:'Gb/delete',
        addrate:'rate/add',
        getrates:'rate/getList',
        delrate:'rate/delete',
        addxd:'xd/add',
        delxd:'xd/delete',
        getxds:'xd/getList',
        delhelp:'helps/delete',
        gethelps:'helps/getList',
        addhelp:'helps/add',
        getsupplys:'SupplyType/getList',
        getproducttype:'productcate/getList',
        getsupplyone:'supply/getOne',
        getcontactlist:'Contactor/getList',
        getcontactone:'Contactor/getOne',
        addsupplyprorelate:'SupplyProductRelate/add',
        addcallbook:'Callbook/add',
        getcalls:'Callbook/getList',
        getcalltypes:'CallbookType/getList',
        delprocate:'Productcate/delete',
        getcustomertypes:'CustomerType/getList',
        getcustomerfrom:'CustomerFrom/getList',
        addcustomer:'Customers/add',
        editcustomer:'Customers/edit',
        getcustomerss:'Customers/getList',
        delcustomer:'Customers/delete',
        editSupply:'Supply/edit',
        delcalls:'Callbook/delete',
        editcallbook:'Callbook/update',
        modifypwd:'Users/editpwd',

    });
});