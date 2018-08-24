<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Selamat Datang,</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Azman</a>
            </div>
        </div>

        <!-- search form -->
       <!--  <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form> -->
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    // ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Home', 'icon' => 'home', 'url' => ['site/index']],
                    ['label' => 'GII', 'icon' => 'dashboard', 'url' => ['/gii']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Buku',
                        'icon' => 'book',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Daftar Buku', 'icon' => 'book', 'url' => ['buku/index'],],
                            ['label' => 'Penulis', 'icon' => 'pencil', 'url' => ['penulis/index'],],
                            ['label' => 'Penerbit', 'icon' => 'dashboard', 'url' => ['penerbit/index'],],
                            ['label' => 'Kategori', 'icon' => 'dashboard', 'url' => ['kategori/index'],],
                            ['label' => 'Peminjaman', 'icon' => 'dashboard', 'url' => ['peminjaman/index'],],
                            
                        ],
                    ],
                    [
                        'label' => 'User',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'User', 'icon' => 'book', 'url' => ['user/index'],],
                            ['label' => 'Anggota', 'icon' => 'home', 'url' => ['anggota/index'],],
                            ['label' => 'Petugas', 'icon' => 'dashboard', 'url' => ['petugas/index'],],
                            ['label' => 'Kategori User', 'icon' => 'dashboard', 'url' => ['user-role/index'],],
                            
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
