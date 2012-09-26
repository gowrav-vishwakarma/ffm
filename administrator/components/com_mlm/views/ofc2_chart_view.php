<html>
    <head>
        <title><?= $page_title ?></title>
        <base href="<?= $this->config->item('base_url') ?>" />
        <script type="text/javascript" src="components/com_mlm/assets/swfobject.js"></script>
        <style type="text/css"> 
            body {
                background-color: #fff;
                margin: 40px;
                font-family: Lucida, Verdana, Sans-serif;
                font-size: 16px;
                color: #4F5155;
            }

            div, h1 {
                margin: 1em 0;
            }

            iframe {
                border: 1px solid silver;
            }

            a {
                color: #003399;
                background-color: transparent;
                font-weight: normal;
            }

            h1 {
                color: #444;
                background-color: transparent;
                font-size: 16px;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        
        <h1><?= $page_title ?></h1>
        <div id="ch">
        <script type="text/javascript">
            swfobject.embedSWF(
              "components/com_mlm/assets/open-flash-chart.swf", "test_chart",
              "<?= $chart_width ?>", "<?= $chart_height ?>",
              "9.0.0", "expressInstall.swf",
              {"data-file":"<?= urlencode($data_url) ?>"}
            );
        </script>
        </div>
        <script type="text/javascript">
            jQuery("#ch").resizable();
        </script>
        <div id="test_chart"></div>

        <div id="links">
            <? foreach ($links as $title => $url): ?>
                <a href="<?= $url ?>"><?=$title?></a>&nbsp;
            <? endforeach ?>
        </div>

        <h1>JSON</h1>
        <iframe src ="<?= $data_url?>" width="80%" height="200">
            <p>No iframes for your browser</p>
        </iframe>

        <div id="info">
            More info &amp; examples: <a href="http://teethgrinder.co.uk/open-flash-chart-2">Open Flash Chart 2 Home</a>
        </div>

    </body>
</html>
