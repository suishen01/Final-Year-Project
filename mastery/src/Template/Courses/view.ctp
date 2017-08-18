<html>
<head>
    <meta charset="utf-8">
    <title>Hierarchical Layout without Physics</title>
    <?php echo $this->Html->script('/vis/dist/vis.js'); ?>
    <?php echo $this->Html->script('/vis/dist/vis-network.min.css'); ?>
    <style type="text/css">
        #network{
            width: 100%;
            height: 95vh;
        }
    </style>
</head>
<body>
<div id="network"></div>
<script>
    var nodes = [];
    <?php for($i = 0; $i < sizeOf($nodes); $i++):?>
        nodes[<?= $i ?>] = {id:<?= h($nodes[$i]['id']); ?>, label:"<?= h($nodes[$i]['label']); ?>", color:"<?= h($nodes[$i]['color']); ?>"};
    <?php endfor; ?>

    var edges = [];
    <?php for($i = 0; $i < sizeOf($edges); $i++):?>
        edges[<?= $i ?>] = {from:<?= h($edges[$i]['from']); ?>, to:<?= h($edges[$i]['to']); ?>, id:"<?= h($edges[$i]['id']); ?>", label:"<?= h($edges[$i]['label']); ?>", dashes:<?= h($edges[$i]['dashes']); ?>, color:"<?= h($edges[$i]['color']); ?>",};
    <?php endfor; ?>

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
                nodeSpacing: 250,
                levelSeparation: 270,
                treeSpacing: 250
            }
        },
        nodes: {
          borderWidth: 3,
          shape: 'circle',
          chosen: false,
          font: {
            size: 20,
            color: "#ffffff"
          },
          widthConstraint: {
            minimum: 150,
            maximum: 150
          },
          shadow: {
            enabled: true
          }
        },
        edges: {
          chosen: false,
          arrows: {
            to: true
          },
          font: {
            size: 20,
            background: "#ffffff"
          },
          dashes: true
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
      for (var i = 0; i < nodes.length; i++) {
        if (nodes[i]['id'] === params.nodes[0] && nodes[i]['color'] !== '#808080') {
          window.location = "http://localhost:8765/tests/view/" + params.nodes[0];
        }
      }
    });
</script>
</body>
</html>
