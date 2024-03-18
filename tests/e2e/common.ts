import dotenv from 'dotenv';

dotenv.config({path: '../../.env'});

export default {
    appUrl: process.env.APP_URL,
    testEmails: {
        chromium: 'david+chromium@docampo.ch',
        firefox: 'david+firefox@docampo.ch',
        webkit: 'david+webkit@docampo.ch',
        mobileChrome: 'david+mobile-chrome@docampo.ch',
        mobileSafari: 'david+mobile-safari@docampo.ch',
    }
}