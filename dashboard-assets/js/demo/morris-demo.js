$(function() {

    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "Teknik Informatika",
            value: document.getElementById("penelitianti").value
        }, {
            label: "Sistem Informasi",
            value: document.getElementById("penelitiansi").value
        }, {
            label: "Sistem Komputer",
            value: document.getElementById("penelitiansk").value
        }],
        resize: true
    });

    d = new Date();
    tahun = d.getFullYear();
    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: tahun-4,
            a: document.getElementById("penelitianti"+(tahun-4)).value,
            b: document.getElementById("penelitiansi"+(tahun-4)).value,
            c: document.getElementById("penelitiansk"+(tahun-4)).value
        }, {
            y: tahun-3,
            a: document.getElementById("penelitianti"+(tahun-3)).value,
            b: document.getElementById("penelitiansi"+(tahun-3)).value,
            c: document.getElementById("penelitiansk"+(tahun-3)).value
        }, {
            y: tahun-2,
            a: document.getElementById("penelitianti"+(tahun-2)).value,
            b: document.getElementById("penelitiansi"+(tahun-2)).value,
            c: document.getElementById("penelitiansk"+(tahun-2)).value
        }, {
            y: tahun-1,
            a: document.getElementById("penelitianti"+(tahun-1)).value,
            b: document.getElementById("penelitiansi"+(tahun-1)).value,
            c: document.getElementById("penelitiansk"+(tahun-1)).value
        }, {
            y: tahun,
            a: document.getElementById("penelitianti"+tahun).value,
            b: document.getElementById("penelitiansi"+tahun).value,
            c: document.getElementById("penelitiansk"+tahun).value
        }],
        xkey: 'y',
        ykeys: ['a', 'b', 'c'],
        labels: ['Teknik Informatika', 'Sistem Informasi', 'Sistem Komputer'],
        hideHover: 'auto',
        resize: true
    });

    Morris.Donut({
        element: 'pub-donut-chart',
        data: [{
            label: "Teknik Informatika",
            value: document.getElementById("publikasiti").value
        }, {
            label: "Sistem Informasi",
            value: document.getElementById("publikasisi").value
        }, {
            label: "Sistem Komputer",
            value: document.getElementById("publikasisk").value
        }],
        resize: true
    });

    Morris.Bar({
        element: 'pub-bar-chart',
        data: [{
            y: tahun-4,
            a: document.getElementById("publikasiti"+(tahun-4)).value,
            b: document.getElementById("publikasisi"+(tahun-4)).value,
            c: document.getElementById("publikasisk"+(tahun-4)).value
        }, {
            y: tahun-3,
            a: document.getElementById("publikasiti"+(tahun-3)).value,
            b: document.getElementById("publikasisi"+(tahun-3)).value,
            c: document.getElementById("publikasisk"+(tahun-3)).value
        }, {
            y: tahun-2,
            a: document.getElementById("publikasiti"+(tahun-2)).value,
            b: document.getElementById("publikasisi"+(tahun-2)).value,
            c: document.getElementById("publikasisk"+(tahun-2)).value
        }, {
            y: tahun-1,
            a: document.getElementById("publikasiti"+(tahun-1)).value,
            b: document.getElementById("publikasisi"+(tahun-1)).value,
            c: document.getElementById("publikasisk"+(tahun-1)).value
        }, {
            y: tahun,
            a: document.getElementById("publikasiti"+tahun).value,
            b: document.getElementById("publikasisi"+tahun).value,
            c: document.getElementById("publikasisk"+tahun).value
        }],
        xkey: 'y',
        ykeys: ['a', 'b', 'c'],
        labels: ['Teknik Informatika', 'Sistem Informasi', 'Sistem Komputer'],
        hideHover: 'auto',
        resize: true
    });

});
