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
    var nodes = [];
    <?php for($i = 0; $i < sizeOf($tests); $i++):?>
        nodes[<?= $i ?>] = {id:<?= h($tests[$i]['id']); ?>, label:"<?= h($tests[$i]['label']); ?>"};
    <?php endfor; ?>
    var edges = [{from:1,to:3,id:"e0"}];
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
        interaction: {
          dragNodes: false,
          dragView: false,
          zoomView: false
        },

        physics: {
            enabled: false
        }
    };
    var network = new vis.Network(container, data, options);

    network.on("selectNode", function (params) {
        if (params.nodes.length === 1) {
            window.location = "http://localhost:8765/tests/view/" + params.nodes[0];
        }
    });
</script>
</body>
</html>
