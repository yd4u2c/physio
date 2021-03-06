.topbar
{
    padding: 10px 0;

    background-color: $topbar-background-color;
    .topbar-wrapper
    {
        display: flex;
        align-items: center;
    }
    a
    {
        font-size: 1.5em;
        font-weight: bold;

        display: flex;
        align-items: center;
        flex: 1;

        max-width: 300px;

        text-decoration: none;

        @include text_headline($topbar-link-font-color);

        span
        {
            margin: 0;
            padding: 0 10px;
        }
    }

    .download-url-wrapper
    {
        display: flex;
        flex: 3;
        justify-content: flex-end;

        input[type=text]
        {
            width: 100%;
            margin: 0;

            border: 2px solid $topbar-download-url-wrapper-element-border-color;
            border-radius: 4px 0 0 4px;
            outline: none;
        }

        .select-label
        {
            display: flex;
            align-items: center;

            width: 100%;
            max-width: 600px;
            margin: 0;
            color: #f0f0f0;
            span
            {
                font-size: 16px;

                flex: 1;

                padding: 0 10px 0 0;

                text-align: right;
            }

            select
            {
                flex: 2;

                width: 100%;

                border: 2px solid $topbar-download-url-wrapper-element-border-color;
                outline: none;
                box-shadow: none;
            }
        }


        .download-url-button
        {
            font-size: 16px;
            font-weight: bold;

            padding: 4px 30px;

            border: none;
            border-radius: 0 4px 4px 0;
            background: $topbar-download-url-button-background-color;

            @include text_headline($topbar-download-url-button-font-color);
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      $gray-base: #000 !default;
$white: #fff !default;
$gray-50: #ebebeb !default;
$gray-100: #d8dde7 !default;
$gray-200: lighten($gray-base, 62.75%) !default; // #aaa
$gray-300: lighten($gray-base, 56.5%) !default; // #999
$gray-400: lighten($gray-base, 50%) !default; // #888
$gray-500: lighten($gray-base, 43.75%) !default; // #777
$gray-600: lighten($gray-base, 37.5%) !default; // #666
$gray-650: lighten($gray-base, 33.3%) !default; // ##555555
$gray-700: lighten($gray-base, 31.25%) !default; // #555
$gray-800: lighten($gray-base, 25%) !default; // #444
$gray-900: lighten($gray-base, 18.75%) !default; // #333

$gray-custom-1: #41444e !default;
$gray-custom-2: #3b4151 !default;

$color-primary: #89bf04 !default;
$color-secondary: #9012fe !default;
$color-info: #4990e2 !default;
$color-warning: #ff6060 !default;
$color-danger: #f00 !default;

$_color-post: #49cc90 !default;
$_color-get: #61affe !default;
$_color-put: #fca130 !default;
$_color-delete: #f93e3e !default;
$_color-head: #9012fe !default;
$_color-patch: #50e3c2 !default;
$_color-disabled: #ebebeb !default;
$_color-options: #0d5aa7 !default;

$color-green: #008000 !default;

$color-primary-hover: #81b10c !default;

// Authorize

$auth-container-border-color: $gray-50 !default;

// Buttons

$btn-background-color: transparent !default;
$btn-border-color: $gray-400 !default;
$btn-font-color: inherit !default;
$btn-box-shadow-color: $gray-base !default;

$btn-authorize-background-color: transparent !default;
$btn-authorize-border-color: $_color-post !default;
$btn-authorize-font-color: $_color-post !default;
$btn-authorize-svg-fill-color: $_color-post !default;

$btn-cancel-background-color: transparent !default;
$btn-cancel-border-color: $color-warning !default;
$btn-cancel-font-color: $color-warning !default;

$btn-execute-background-color: transparent !default;
$btn-execute-border-color: $color-info !default;
$btn-execute-font-color: $white !default;
$btn-execute-background-color-alt: $color-info !default;

$expand-methods-svg-fill-color: $gray-500 !default;
$expand-methods-svg-fill-color-hover: $gray-800 !default;

// Errors

$errors-wrap