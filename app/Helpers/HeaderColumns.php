<?php
function headerColumns($page = ''){
    if($page == 'modules'){
        
        return array(
            ['SL', 'SL', 'text-center'],
            ['serial', 'serial', 'text-center'],
            ['name', 'name', 'text-center'],
            ['route', 'route', 'text-center'],
            ['icon', 'icon', 'text-center'],
            ['menu', 'menu', 'text-center'],
            ['description', 'description'],
            ['actions', 'actions', 'text-center'],
        );

    }elseif($page == 'menu'){
        
        return array(
            ['SL', 'SL', 'text-center'],
            ['module', 'module', 'text-center'],
            ['serial', 'serial', 'text-center'],
            ['name', 'name', 'text-center'],
            ['route', 'route', 'text-center'],
            ['icon', 'icon', 'text-center'],
            ['submenu', 'submenu', 'text-center'],
            ['description', 'description', 'text-center'],
            ['actions', 'actions', 'text-center'],
        );

    }elseif($page == 'submenu'){
        
        return array(
            ['SL', 'SL', 'text-center'],
            ['module', 'module', 'text-center'],
            ['menu', 'menu', 'text-center'],
            ['serial', 'serial', 'text-center'],
            ['name', 'name', 'text-center'],
            ['route', 'route', 'text-center'],
            ['icon', 'icon', 'text-center'],
            ['description', 'description', 'text-center'],
            ['actions', 'actions', 'text-center'],
        );

    }elseif($page == 'permissions'){
        
        return array(
            ['SL', 'SL', 'text-center'],
            ['module', 'module', 'text-center'],
            ['name', 'name', 'text-center'],
            ['guard_name', 'guard_name', 'text-center'],
            ['actions', 'actions', 'text-center'],
        );

    }elseif($page == 'roles'){
        
        return array(
            ['SL', 'SL', 'text-center'],
            ['name', 'name', 'text-center'],
            ['guard_name', 'guard_name', 'text-center'],
            ['actions', 'actions', 'text-center'],
        );

    }elseif($page == 'departments'){
        
        return array(
            ['SL', 'SL', 'text-center'],
            ['code', 'code', 'text-center'],
            ['name', 'name', 'text-center'],
            ['description', 'description', 'text-center'],
            ['actions', 'actions', 'text-center'],
        );

    }elseif($page == 'courses'){
        
        return array(
            ['SL', 'SL', 'text-center'],
            ['code', 'code', 'text-center'],
            ['name', 'name', 'text-center'],
            ['description', 'description', 'text-center'],
            ['actions', 'actions', 'text-center'],
        );

    }elseif($page == 'users'){

        return array(
            ['SL', 'SL', 'text-center'],
            ['first_name', 'first_name', 'text-center'],
            ['last_name', 'last_name', 'text-center'],
            ['email', 'email', 'text-center'],
            ['username', 'username', 'text-center'],
            ['roles', 'roles', 'text-center'],
            ['actions', 'actions', 'text-center'],
        );

    }elseif($page == 'user-courses'){

        return array(
            ['SL', 'SL', 'text-center'],
            ['student', 'student', 'text-center'],
            ['email', 'email', 'text-center'],
            ['department', 'department', 'text-center'],
            ['courses', 'courses', 'text-center'],
            ['options', 'options', 'text-center'],
        );

    }elseif($page == 'course-fees'){

        return array(
            ['SL', 'SL', 'text-center'],
            ['course', 'course', 'text-center'],
            ['date', 'date', 'text-center'],
            ['fee', 'fee', 'text-right'],
            ['description', 'description', 'text-center'],
            ['actions', 'actions', 'text-center'],
        );

    }elseif($page == 'user-bills'){

        return array(
            ['SL', 'SL', 'text-center'],
            ['student', 'student', 'text-center'],
            ['course', 'course', 'text-center'],
            ['deadline', 'deadline', 'text-center'],
            ['fee', 'fee', 'text-right'],
            ['collections', 'collections', 'text-right'],
            ['due', 'due', 'text-right'],
            ['description', 'description', 'text-center'],
        );

    }elseif($page == 'fee-collections'){

        return array(
            ['SL', 'SL', 'text-center'],
            ['student', 'student', 'text-center'],
            ['email', 'email', 'text-center'],
            ['department', 'department', 'text-center'],
            ['courses', 'courses', 'text-center'],
            ['total_bills', 'total_bills', 'text-center'],
            ['total_collections', 'total_collections', 'text-center'],
            ['due', 'due', 'text-center'],
            ['options', 'options', 'text-center'],
        );

    }elseif($page == 'notifications'){

        return array(
            ['SL', 'SL', 'text-center'],
            ['student', 'student', 'text-center'],
            ['course', 'course', 'text-center'],
            ['deadline', 'deadline', 'text-center'],
            ['fee', 'fee', 'text-right'],
            ['collections', 'collections', 'text-right'],
            ['due', 'due', 'text-right'],
            ['notification', 'notification', 'text-center'],
        );

    }elseif($page == ''){
        
        return array(
            ['SL', 'SL', 'text-center'],
        );

    }

    return [];
}