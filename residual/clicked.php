<html>
<head>
    <title>Trial</title>
</head>

<body>
    <div id="alphabet">
        <button id="A">A</button>
        <button id="B">B</button>
        <button id="C">C</button>
        <button id="D">D</button>
        <button id="E">E</button>
        <button id="F">F</button>
        <button id="G">G</button>
        <button id="H">H</button>
        <button id="I">I</button>
        <button id="J">J</button>
        <button id="K">K</button>
        <button id="L">L</button>
        <button id="M">M</button>
        <button id="N">N</button>
        <button id="O">O</button>
        <button id="P">P</button>
        <button id="Q">Q</button>
        <button id="R">R</button>
        <button id="S">S</button>
        <button id="T">T</button>
        <button id="U">U</button>
        <button id="V">V</button>
        <button id="W">W</button>
        <button id="X">X</button>
        <button id="Y">Y</button>
        <button id="Z">Z</button>
    </div>

    <script>
        window.onload = myMain;

        function myMain () {
            document.getElementById ("alphabet").onclick = buton;
        }

        function buton (e) {
            if (e.target.tagName == 'BUTTON') {
                alert (e.target.id);
            }
        }
    </script>

</body>
</html>