var urlBaseMeme = "https://damemeapi.000webhostapp.com/meme"
var urlBaseTag = "https://damemeapi.000webhostapp.com/tag"

function obtener_memes() {

    var page = $('#obtenerMemes_page').val()
    var count = $('#obtenerMemes_count').val()

    //Comprobamos is los valores son  nulos
    if (count == null || count == "?count=") count = 5
    if (page == null || count == "?page=") count = 0

    //creamos ub ibjetoc con los valores recibidos
    var data = {
        "count": count,
        "page": page
    };


    //se los concatenamos a la URL
    var url = new URL(urlBaseMeme + "/list");
    for (let k in data) {
        url.searchParams.append(k, data[k]);
    }



    //Obtenemos los datos y los concatenamos

    fetch(url, { crossDomain: true })
        .then(response => response.json())
        .then(json_data => {
            var string_json = JSON.stringify(json_data);
            var arrayMemes = JSON.parse(string_json);
            $('#memeHolder').html("");
            arrayMemes.forEach(function (meme) {
                var memeHolder = '<div class="meme-generator">'
                    + '<canvas id="meme' + meme.idMeme + '"></canvas>'
                    + '<a class="btn btn-danger"  href="https://damemeapi.000webhostapp.com/meme/borrar?id=' + meme.idMeme + '">Borrar</a>                '
                    + '</div>';
                $('#memeHolder').append(memeHolder);

                let canvas = document.querySelector("#meme" + meme.idMeme);
                let image = new Image();
                image.src = meme.url;
                image.addEventListener(
                    "load",
                    () => {
                        updateMemeCanvas(
                            canvas,
                            image,
                            meme.tSuperior,
                            meme.tInferior
                        );
                    },
                    { once: true }
                );
            });
        });
}



function updateMemeCanvas(canvas, image, topText, bottomText) {

    const ctx = canvas.getContext("2d");
    const width = image.width;
    const height = image.height;
    const fontSize = Math.floor(width / 10);
    const yOffset = height / 25;

    // Update canvas background
    canvas.width = width;
    canvas.height = height;
    ctx.drawImage(image, 0, 0);

    // Prepare text
    ctx.strokeStyle = "black";
    ctx.lineWidth = Math.floor(fontSize / 4);
    ctx.fillStyle = "white";
    ctx.textAlign = "center";
    ctx.lineJoin = "round";
    ctx.font = `${fontSize}px sans-serif`;

    // Add top text
    ctx.textBaseline = "top";
    ctx.strokeText(topText, width / 2, yOffset);
    ctx.fillText(topText, width / 2, yOffset);

    // Add bottom text
    ctx.textBaseline = "bottom";
    ctx.strokeText(bottomText, width / 2, height - yOffset);
    ctx.fillText(bottomText, width / 2, height - yOffset);
}

function obtener_memePorId() {

    var id = $('#obtenerMemePorId_id').val()

    //Comprobamos el valor no es  nulo
    id == null ?? 1;

    //se los concatenamos a la URL
    var url = new URL(urlBaseMeme);
    url.searchParams.append("id", id);

    //Obtenemos los datos y los concatenamos
    fetch(url)
        .then(response => response.json())
        .then(json_data => {
            var string_json = JSON.stringify(json_data);
            var meme = JSON.parse(string_json);
            var memeHolder = '<div class="meme-generator">'
                + '<canvas id="meme"></canvas>'
                + '</div>';
            $('#memeHolder').html(memeHolder);

            const canvas = document.querySelector("#meme");
            image = new Image();
            image.src = meme.url;
            image.addEventListener(
                "load",
                () => {
                    updateMemeCanvas(
                        canvas,
                        image,
                        meme.tSuperior,
                        meme.tInferior
                    );
                },
                { once: true }
            );
        });
}





function crearTag() {

    var tag = $('#crearTag_nombreTag').val()
    //Comprobamos el valor no es  nulo

    if (tag == null || tag == "") {
        indicar_error("No se ha introducido un Tag")
        return;
    }

    var data = { 'tagNombre': tag };

    //Obtenemos los datos y los concatenamos
    fetch(urlBaseTag, {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })

        .then(response => response.json())
        .then(json_data => {

            var string_json = JSON.stringify(json_data);
            var tag = JSON.parse(string_json);
            document.getElementById("meme").textContent = JSON.stringify(tag, undefined, 2);
        }).catch(error =>
            indicar_error(error)
        );

}

function obtenerTagLista() {

    //Obtenemos los datos y los concatenamos
    fetch(urlBaseTag)
        .then(response => response.json())
        .then(json_data => {
            var string_json = JSON.stringify(json_data);
            var arrayTags = JSON.parse(string_json);

            document.getElementById("memeHolder").textContent = JSON.stringify(arrayTags, undefined, 2);
        });
}

function crearMeme() {

    var nombre = $('#crearMeme_nombre').val()
    var tSuperior = $('#crearMeme_tSuperior').val()
    var tInferior = $('#crearMeme_tInferior').val()
    var url = $('#crearMeme_url').val()
    var tags = $('#crearMeme_tags').val()

    //Comprobamos is los valores son  nulos
    tSuperior == null ?? "";
    tInferior == null ?? "";

    //Comprobamos el valor no es  nulo
    if (nombre == null || nombre == "" || url == null || url == "" || tags == null || tags == "") {
        indicar_error("No se ha introducido los campos necesarios")
        return;
    }

    var data = { 'nombre': nombre, 'tSuperior': tSuperior, 'tInferior': tInferior, 'url': url, 'tags': tags };

    //Obtenemos los datos y los concatenamos
    fetch(urlBaseMeme, {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
        .then(response => response.json())
        .then(json_data => {

            var string_json = JSON.stringify(json_data);
            var meme = JSON.parse(string_json);

            var memeHolder = '<div class="meme-generator">'
                + '<canvas id="meme"></canvas>'
                + '</div>';
            $('#memeHolder').html(memeHolder);

            const canvas = document.querySelector("#meme");

            image = new Image();
            image.src = meme.url;
            image.addEventListener(
                "load",
                () => {
                    updateMemeCanvas(
                        canvas,
                        image,
                        meme.tSuperior,
                        meme.tInferior
                    );
                },
                { once: true }
            );
        });

}





function editarMeme() {

    var idMeme = $('#editarMeme_id').val()
    var nombre = $('#editarMeme_nombre').val()
    var tSuperior = $('#editarMeme_tSuperior').val()
    var tInferior = $('#editarMeme_tInferior').val()
    var url = $('#editarMeme_url').val()
    var tags = $('#editarMeme_tags').val()



    //Comprobamos is los valores son  nulos
    if (tSuperior == null || tSuperior == "?tSuperior=") tSuperior = ""
    if (tInferior == null || tInferior == "?tInferior=") tInferior = ""

    //Comprobamos el valor no es  nulo
    if (idMeme == null || idMeme == "" || nombre == null || nombre == "" || url == null || url == "" || tInferior == null || tags == "") {
        indicar_error("No se ha introducido los campos necesarios")
        return;
    }

    var data = { 'idMeme': idMeme, 'nombre': nombre, 'tSuperior': tSuperior, 'tInferior': tInferior, 'url': url, 'tags': tags };

    //Obtenemos los datos y los concatenamos
    fetch(urlBaseMeme, {
        method: "PUT",
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
        .then(response => response.json())
        .then(json_data => {

            var string_json = JSON.stringify(json_data);
            var meme = JSON.parse(string_json);
            var memeHolder = '<div class="meme-generator">'
                + '<canvas id="meme"></canvas>'
                + '</div>';
            $('#memeHolder').html(memeHolder);

            const canvas = document.querySelector("#meme");
            image = new Image();
            image.src = meme.url;
            image.addEventListener(
                "load",
                () => {
                    updateMemeCanvas(
                        canvas,
                        image,
                        meme.titSup,
                        meme.titInf
                    );
                },
                { once: true }
            );
        });

}

function indicar_error(texto) {

    var alert = '<div class="alert alert-dismissible alert-warning">'
        + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>'
        + '<h4 class="alert-heading">Warning!</h4>'
        + '<p class="mb-0">' + texto + ' </p>'
        + '</div>';
    $('#meme').html(alert);
}


document.addEventListener("DOMContentLoaded", () => {

    $('#obtenerMemes').click(obtener_memes)
    $('#obtenerMemePorId').click(obtener_memePorId)
    $('#crearTag_boton').click(crearTag)
    $('#obtenerTagLista').click(obtenerTagLista)
    $('#crearMeme_boton').click(crearMeme)
    $('#editarMeme_boton').click(editarMeme)
});

