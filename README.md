# Class loader component

自动加载组件主要帮助开发者解决在项目中的类加载问题，只要您的项目符合规范，那么您可以避免在类的加载问题上付出过多精力。

### 安装

在composer.json中添加

    {
        "require": {
            "slince/loader": "dev-master@dev"
        }
    }

### 用法

最简单的用法，配置classmap

    $map = [
        'ClassA' => 'path/to/classa.php',
        'ClassB' => 'path/to/classb.php',
    ];
    $loader = new Slince\Loader\ClassLoader();
    $loader->addLoader(new Slince\Loader\Loader\ClassMapLoader($map))->register();

如果您的项目符合psr规范

    $psr4Loader = new Slince\Loader\Psr4Loader();
    //设置命名空间与路径的映射
    $psr4Loader->setPrefixPath('I\\Like\\To\\Read\\Book', './src/');
   



