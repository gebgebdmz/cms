<!-- <ul class="navbar-nav">
    < ?php 
    
    use App\Menu;
    use App\App;
    use App\Role;
    use App\User;
 

    $roles =Request::session()->get('role');

    If(count($roles) > 0) {
        $role = DB::table('bas_role')->where('name',$roles[0])->get();
   
                $menu = DB::table('bas_menu')->where('role_id',$role[0]->id)->select()->distinct('app_name')->get();
       
            $resultMenu = array();
            foreach ($menu as $m) {
                $app = DB::table('bas_app')->where('app_name', $m->app_name)->select('menu_url')->get();
                if (count($app) > 0) {
                    $newApp = array(
                        'name_app' => $m->app_name,
                        'url' => $app[0]->menu_url
                    );
                    array_push($resultMenu, $newApp);
                }
            }
        foreach($resultMenu as $r){
        echo '<li class="nav-item"><a class="nav-link active" href="'.$r['url'].'"> <i class="ni ni-tv-2 text-primary"></i> <span class="nav-link-text">'.$r['name_app'].'</span></a> </li';
        }
            } else {
                return view('home');
            }
                
    
 ?> 
          </ul> -->
