require('./bootstrap');
import VueAxios from 'vue-axios';
import Swal from 'sweetalert2';
import moment from 'moment';
import Datepicker from 'vuejs-datepicker';
import {
    total,
    pageTotal,
} from 'datatables';
window.Swal = Swal;
window.total = total;
window.pageTotal = pageTotal;
window.Datepicker = Datepicker;

// Pop-Up Notifikasi
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
window.Toast = Toast;
// End Pop-Up Notifikasi

window.Vue = require('vue');
import {
    Form,
    HasError,
    AlertError,
    AlertErrors,
    AlertSuccess
} from 'vform';
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component(AlertErrors.name, AlertErrors);
Vue.component(AlertSuccess.name, AlertSuccess);
import VueRouter from 'vue-router';
Vue.use(VueRouter, VueAxios);
import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199',
    failedColor: 'red',
    height: '3px',
});
window.Fire = new Vue();

import VueNumeric from 'vue-numeric';
Vue.use(VueNumeric);

Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');
Vue.prototype.$username = document.querySelector("meta[name='username']").getAttribute('content');
Vue.prototype.$userLevel = document.querySelector("meta[name='user-level']").getAttribute('content');
let userLevel = document.querySelector("meta[name='user-level']").getAttribute('content');
let routes = [{
    path: '/403',
    component: require('./components/Error Pages/403.vue').default
}, {
    path: '/dashboard',
    component: require('./components/Dashboard.vue').default,
    beforeEnter: (to, from, next) => {
        if (userLevel != 'GUEST') {
            next();
        } else {
            next('/report');
        }
    }
}, {
    path: '/report',
    component: require('./components/Laporan Data/Report Supir.vue').default,
    beforeEnter: (to, from, next) => {
        if (userLevel == 'GUEST') {
            next();
        } else {
            next('/403');
        }
    }
},{
    path: '/report-history',
    component: require('./components/Laporan Data/History Report Supir.vue').default,
    beforeEnter: (to, from, next) => {
        if (userLevel == 'GUEST') {
            next();
        } else {
            next('/403');
        }
    }
}, {
    path: '/user-management',
    component: require('./components/Data Master/User Management.vue').default,
    beforeEnter: (to, from, next) => {
        if (userLevel == 'Super Admin') {
            next();
        } else {
            next('/403');
        }
    }
}, {
    path: '/rekapitulasi',
    component: require('./components/Rekapitulasi.vue').default,
    beforeEnter: (to, from, next) => {
        if (userLevel == 'Super Admin' || userLevel == 'Admin') {
            next();
        } else {
            next('/403');
        }
    }
}, {
    path: '/data-master/kendaraan',
    component: require('./components/Data Master/Kendaraan.vue').default,
    beforeEnter: (to, from, next) => {
        if (userLevel == 'Super Admin') {
            next();
        } else {
            next('/403');
        }
    }
}, {
    path: '/data-master/kota',
    component: require('./components/Data Master/Data Kota.vue').default,
    beforeEnter: (to, from, next) => {
        if (userLevel == 'Super Admin') {
            next();
        } else {
            next('/403');
        }
    }
}, {
    path: '/data-master/muatan',
    component: require('./components/Data Master/Data Muatan.vue').default,
    beforeEnter: (to, from, next) => {
        if (userLevel == 'Super Admin') {
            next();
        } else {
            next('/403');
        }
    }
}, {
    path: '/data-master/pelanggan',
    component: require('./components/Data Master/Data Pelanggan.vue').default,
    beforeEnter: (to, from, next) => {
        if (userLevel == 'Super Admin') {
            next();
        } else {
            next('/403');
        }
    }
}, {
    path: '/data-master/ongkos-biaya',
    component: require('./components/Data Master/Data Ongkos.vue').default,
    beforeEnter: (to, from, next) => {
        if (userLevel == 'Super Admin') {
            next();
        } else {
            next('/403');
        }
    }
}, {
    path: '/input-data/angkutan',
    component: require('./components/Input Data/Angkutan.vue').default,
    beforeEnter: (to, from, next) => {
        if (userLevel == 'Admin') {
            next();
        } else {
            next('/403');
        }
    }
}, {
    path: '/data/angkutan',
    component: require('./components/Laporan Data/Angkutan.vue').default,
    beforeEnter: (to, from, next) => {
        if (userLevel == 'Super Admin' || userLevel == 'Admin') {
            next();
        } else {
            next('/403');
        }
    }
},{
    path: '/data/angkutan-vendor',
    component: require('./components/Laporan Data/Angkutan Vendor.vue').default,
    beforeEnter: (to, from, next) => {
        if (userLevel == 'Super Admin' || userLevel == 'Admin') {
            next();
        } else {
            next('/403');
        }
    }
}, {
    path: '/ubah-data/angkutan/:id',
    component: require('./components/Ubah Data/Angkutan.vue').default,
    beforeEnter: (to, from, next) => {
        if (userLevel == 'Super Admin' || userLevel == 'Admin') {
            next();
        } else {
            next('/403');
        }
    }
}, {
    path: '/input-data/perawatan',
    component: require('./components/Input Data/Perawatan.vue').default,
    beforeEnter: (to, from, next) => {
        if (userLevel == 'Super Admin' || userLevel == 'Admin') {
            next();
        } else {
            next('/403');
        }
    }
}, {
    path: '/data/perawatan',
    component: require('./components/Laporan Data/Perawatan.vue').default,
    beforeEnter: (to, from, next) => {
        if (userLevel == 'Super Admin' || userLevel == 'Admin') {
            next();
        } else {
            next('/403');
        }
    }
}, {
    path: '/ubah-data/perawatan/:id',
    component: require('./components/Ubah Data/Perawatan.vue').default,
    beforeEnter: (to, from, next) => {
        if (userLevel == 'Super Admin' || userLevel == 'Admin') {
            next();
        } else {
            next('/403');
        }
    }
}, {
    path: '/rekap-persupir',
    component: require('./components/Laporan Data/Report PerSupir.vue').default,
    beforeEnter: (to, from, next) => {
        if (userLevel == 'Super Admin' || userLevel == 'Admin') {
            next();
        } else {
            next('/403');
        }
    }
}, {
    path: '/rekap-pervendor',
    component: require('./components/Laporan Data/Report PerVendor.vue').default,
    beforeEnter: (to, from, next) => {
        if (userLevel == 'Super Admin' || userLevel == 'Admin') {
            next();
        } else {
            next('/403');
        }
    }
}, {
    path: '/filter-angkutan-palembang',
    component: require('./components/Laporan Data/Angkutan Palembang.vue').default,
    beforeEnter: (to, from, next) => {
        if (userLevel == 'Super Admin') {
            next();
        } else {
            next('/403');
        }
    }
}, {
    path: '/approval-data-perawatan',
    component: require('./components/Laporan Data/Approval Perawatan.vue').default,
    beforeEnter: (to, from, next) => {
        if (userLevel == 'Super Admin') {
            next();
        } else {
            next('/403');
        }
    }
}, {
    path: '/penggajian/data-gaji',
    component: require('./components/Penggajian/Data Gaji.vue').default,
    beforeEnter: (to, from, next) => {
        if (userLevel == 'Super Admin' || userLevel == 'Keuangan') {
            next();
        } else {
            next('/403');
        }
    }
},{
    path: '/penggajian/data-karyawan',
    component: require('./components/Penggajian/Data Karyawan.vue').default,
    beforeEnter: (to, from, next) => {
        if (userLevel == 'Super Admin' || userLevel == 'Keuangan') {
            next();
        } else {
            next('/403');
        }
    }
}, {
    path: '/penggajian/input-penggajian',
    component: require('./components/Penggajian/Input Penggajian.vue').default,
    beforeEnter: (to, from, next) => {
        if (userLevel == 'Super Admin' || userLevel == 'Keuangan') {
            next();
        } else {
            next('/403');
        }
    }
},];
const router = new VueRouter({
    mode: 'history',
    routes,
});

Vue.filter('currency', function (value) {
    let rp = (value / 1).toFixed(0).replace('.', ',')
    return rp.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
});
Vue.filter('uppercase', function (value) {
    return value.toUpperCase();
});
Vue.filter('nopolFormat', function (value) {
    let nopol = value.split(/(\d+)/);
    return nopol[0] + ' ' + nopol[1] + ' ' + nopol[2];
});
Vue.filter('dateReformat', function (value) {
    var month = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
        "September",
        "Oktober", "November", "Desember"
    ];
    var datevalue = new Date(value);
    var newdate = datevalue.getDate();
    var newmonth = datevalue.getMonth();
    var newyear = datevalue.getFullYear();
    return newdate + ' ' + month[newmonth] + ' ' + newyear;
});

const app = new Vue({
    el: '#app',
    router,
});
// Script

