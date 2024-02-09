# How it works

Many social media platforms use [cookies](https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies) 
for various purposes. This can include necessary functionality but often includes usage for data-analysis 
and marketing. Under [GDPR regulations](https://gdpr.eu/cookies/) if a website uses anything more than 
strictly necessary cookies created by the website itself, user consent is required.

## How does mmbd.io prevent cookies from other Websites

There are some technical tools to prevent loading cookies from third party websites. Sometimes websites like
YouTube offer a way to embed content without cookies f.ex. over a different domain like `youtube-nocookie.com`.

In other instances embedded content doesn't create cookies, or it can be prevented by other technical means.

### YouTube

All embedded content is embedded from `www.youtube-nocookie.com` not from `www.youtube.com` directly. 
The iframe used to show the YouTube video is also loaded with the [sandbox mode](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/iframe?retiredLocale=de#sandbox) 
enabled, only allowing `allow-scripts` to allow the execution of JavaScript from YouTube and the `allow-same-origin`
which is required to load the video in the iframe at all. The `allowfullscreen="allowfullscreen"` attribute is also
set to allow YouTube to display the video in Fullscreen on [mmbd.io](https://mmbd.io).

# Why does mmbd.io not display cookie messages?

We have to admit... we use cookies too. But hold on, it's not what you think.
We only use 2 Cookies strictly necessary for functionality or security. 
The `mmbdio_session` (necessary functionality) cookie and the `XSRF-TOKEN` (security) cookie.

## Technical Section

### The `mmbdio_session` cookie

This cookie stores information about your "session". Your "session" stores important context 
between visits of different pages of [mmbd.io](https://mmbd.io). For example if you create a new link,
you are redirected to the [mmbd.io/post/success](https://mmbd.io/post/success) page. On this page a link
is displayed to share your media. This link is passed as a "flash message". The "flash message" is 
temporarily stored in your session. The "flash message" is deleted right after
the [mmbd.io/post/success](https://mmbd.io/post/success) page is loaded. To be able to identify your session
this cookie is used in combination with your [public IP address](https://en.wikipedia.org/wiki/IP_address#Public_address)
and your [User Agent](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/User-Agent).

### The `XSRF-TOKEN` cookie

This cookie exists for security purposes. The value stored in this cookie prevents so called
"CSRF" or "Cross-Site Request Forgery" Attacks. Without this cookie, someone could impersonate you
and send requests from another website to [mmbd.io](https://mmbd.io) without your knowledge.