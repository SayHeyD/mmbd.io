import dotenv from 'dotenv';

dotenv.config({path: '../../.env'});

export default {
    appUrl: process.env.APP_URL
}