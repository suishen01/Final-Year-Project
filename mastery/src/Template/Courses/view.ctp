<html>
<head>
    <meta charset="utf-8">
    <title>Hierarchical Layout without Physics</title>
    <?php echo $this->Html->script('/vis/dist/vis.js'); ?>
    <?php echo $this->Html->script('/vis/dist/vis-network.min.css'); ?>
    <style type="text/css">
        #network{
            width: 100%;
            height: 1000px;
        }
    </style>
</head>
<body>
<div id="network"></div>
<script>

    var nodes = [{id:1,label:"Test 1"},{id:2,label:"Test 2"},{id:3,label:"Test 3"},{id:4,label:"Test 4"},{id:5,label:"Test 5"},{id:0,label:"Test 6"}];
    var edges = [{from:0,to:1,id:"e0"},{from:1,to:3,id:"e1"},{from:2,to:3,id:"e2"},{from:0,to:2,id:"e4"},{from:4,to:5,id:"e5"}];
    var data = {
        nodes: nodes,
        edges: edges
    };
    // create a network
    var container = document.getElementById('network');
    var options = {
        layout: {
            hierarchical: {
                direction: "UD",
                sortMethod: "directed",
                nodeSpacing: 300,
                levelSeparation: 250,
                treeSpacing: 300
            }
        },
        nodes: {
          shape: 'circle',
          widthConstraint: {
            minimum: 100,
            maximum: 100
          }
        },
        edges: {
          arrows: {
            to: true
          }
        },
        interaction: {dragNodes :false, dragView :false},
        physics: {
            enabled: false
        }
    };
    var network = new vis.Network(container, data, options);

    network.on("selectNode", function (params) {
      alert(<?=$course?>.tests[0].id);
        if (params.nodes.length === 1) {
            //window.location = "http://localhost:8765/tests/view/" + params.nodes[0];
        }
    });
</script>
</body>
</html>
