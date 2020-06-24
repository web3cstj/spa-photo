import Hello from './views/Hello'
import Home from './views/Home'
import Photo from './views/Photo'

export default [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/hello',
        name: 'hello',
        component: Hello,
    },
    {
        path: '/photo',
        name: 'photo',
        component: Photo,
    },
];
