<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    @vite('resources/css/sidebar.css')
</head>

<body>
    <div class="wrap-sidebar">
        <div class="wrap-content-sidebar">
            <h3>myRTB</h3>
            <div class="content-sidebar">
                <a href="/dashboard/forum" class="card-sidebar {{Request::is('dashboard/forum') ? 'active' : ''}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                        fill="none">
                        <path
                            d="M3.33325 16.7249C3.33325 12.0891 7.08992 8.33325 11.7249 8.33325H18.2749C22.9108 8.33325 26.6666 12.0899 26.6666 16.7249C26.6666 21.3583 22.9099 25.1158 18.2749 25.1158H13.3333V29.1666C13.3333 29.1666 3.33325 27.1416 3.33325 16.7249Z"
                            fill="#currentColor" />
                        <path
                            d="M20.3975 26.5558C21.6464 27.7579 23.3132 28.4283 25.0466 28.4258H27.5V31.6667C27.5 31.6667 36.6666 30.0467 36.6666 21.7133C36.6666 19.933 35.9594 18.2256 34.7006 16.9666C33.4418 15.7076 31.7345 15.0002 29.9541 15H28.1125C28.2566 15.5467 28.3333 16.1208 28.3333 16.7133C28.3333 21.5417 24.9333 25.5767 20.3975 26.5558Z"
                            fill="#currentColor" />
                    </svg>
                    <p>Forum</p>
                </a>
                <a href="/dashboard/mesincuci" class="card-sidebar {{Request::is('dashboard/mesincuci') ? 'active' : ''}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="25" viewBox="0 0 18 18"
                        fill="none">
                        <path
                            d="M5.25 10.75C5.24851 9.81001 5.6001 8.90374 6.23514 8.21069C6.87017 7.51763 7.74232 7.08835 8.67886 7.00785C9.6154 6.92735 10.548 7.20151 11.292 7.77604C12.036 8.35056 12.5371 9.18354 12.696 10.11C12.5093 10.2851 12.2933 10.4262 12.058 10.527C11.524 10.757 10.642 10.895 9.121 10.515C7.424 10.091 6.281 10.343 5.481 10.839C5.40476 10.8861 5.33037 10.9361 5.258 10.989C5.25283 10.9094 5.25017 10.8297 5.25 10.75ZM3.25 0C2.38805 0 1.5614 0.34241 0.951903 0.951903C0.34241 1.5614 0 2.38805 0 3.25V14.75C0 15.612 0.34241 16.4386 0.951903 17.0481C1.5614 17.6576 2.38805 18 3.25 18H14.75C15.612 18 16.4386 17.6576 17.0481 17.0481C17.6576 16.4386 18 15.612 18 14.75V3.25C18 2.38805 17.6576 1.5614 17.0481 0.951903C16.4386 0.34241 15.612 0 14.75 0H3.25ZM5 4.25C4.73478 4.25 4.48043 4.14464 4.29289 3.95711C4.10536 3.76957 4 3.51522 4 3.25C4 2.98478 4.10536 2.73043 4.29289 2.54289C4.48043 2.35536 4.73478 2.25 5 2.25C5.26522 2.25 5.51957 2.35536 5.70711 2.54289C5.89464 2.73043 6 2.98478 6 3.25C6 3.51522 5.89464 3.76957 5.70711 3.95711C5.51957 4.14464 5.26522 4.25 5 4.25ZM9 3.25C9 3.05109 9.07902 2.86032 9.21967 2.71967C9.36032 2.57902 9.55109 2.5 9.75 2.5H13.25C13.4489 2.5 13.6397 2.57902 13.7803 2.71967C13.921 2.86032 14 3.05109 14 3.25C14 3.44891 13.921 3.63968 13.7803 3.78033C13.6397 3.92098 13.4489 4 13.25 4H9.75C9.55109 4 9.36032 3.92098 9.21967 3.78033C9.07902 3.63968 9 3.44891 9 3.25ZM9 5.5C9.68944 5.5 10.3721 5.6358 11.0091 5.89963C11.646 6.16347 12.2248 6.55018 12.7123 7.03769C13.1998 7.5252 13.5865 8.10395 13.8504 8.74091C14.1142 9.37787 14.25 10.0606 14.25 10.75C14.25 11.4394 14.1142 12.1221 13.8504 12.7591C13.5865 13.396 13.1998 13.9748 12.7123 14.4623C12.2248 14.9498 11.646 15.3365 11.0091 15.6004C10.3721 15.8642 9.68944 16 9 16C7.60761 16 6.27225 15.4469 5.28769 14.4623C4.30312 13.4777 3.75 12.1424 3.75 10.75C3.75 9.35761 4.30312 8.02225 5.28769 7.03769C6.27225 6.05312 7.60761 5.5 9 5.5Z"
                            fill="#currentColor" />
                    </svg>
                    <p>Washing Machine</p>
                </a>
                <a href="/dashboard/coworking" class="card-sidebar {{Request::is('dashboard/coworking') ? 'active' : ''}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="30" viewBox="0 0 22 22"
                        fill="none">
                        <path
                            d="M16.4999 10.0835C17.8658 10.0835 19.1308 10.5143 20.1666 11.2385V7.3335C20.1666 6.316 19.3508 5.50016 18.3333 5.50016H14.6666V3.66683C14.6666 2.64933 13.8508 1.8335 12.8333 1.8335H9.16659C8.14909 1.8335 7.33325 2.64933 7.33325 3.66683V5.50016H3.66659C2.64909 5.50016 1.84242 6.316 1.84242 7.3335L1.83325 17.4168C1.83325 18.4343 2.64909 19.2502 3.66659 19.2502H10.7066C10.2415 18.2726 10.0315 17.1931 10.0962 16.1124C10.1609 15.0318 10.4982 13.9851 11.0765 13.0699C11.6549 12.1548 12.4556 11.401 13.4039 10.8788C14.3522 10.3566 15.4173 10.083 16.4999 10.0835ZM9.16659 3.66683H12.8333V5.50016H9.16659V3.66683Z"
                            fill="#currentColor" />
                        <path
                            d="M16.5001 11.9165C13.9701 11.9165 11.9167 13.9698 11.9167 16.4998C11.9167 19.0298 13.9701 21.0832 16.5001 21.0832C19.0301 21.0832 21.0834 19.0298 21.0834 16.4998C21.0834 13.9698 19.0301 11.9165 16.5001 11.9165ZM18.0126 18.654L16.0417 16.6832V13.7498H16.9584V16.3073L18.6542 18.0032L18.0126 18.654Z"
                            fill="#currentColor" />
                    </svg>
                    <p>Co-working Space</p>
                </a>
                <a href="/dashboard/serbaguna" class="card-sidebar {{Request::is('dashboard/serbaguna') ? 'active' : ''}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="30" viewBox="0 0 24 24"
                        fill="none">
                        <path
                            d="M5.6001 8.2001C5.6001 7.24532 5.97938 6.32964 6.65451 5.65451C7.32964 4.97938 8.24532 4.6001 9.2001 4.6001H18.8001C19.7549 4.6001 20.6706 4.97938 21.3457 5.65451C22.0208 6.32964 22.4001 7.24532 22.4001 8.2001V17.8001C22.4001 18.7549 22.0208 19.6706 21.3457 20.3457C20.6706 21.0208 19.7549 21.4001 18.8001 21.4001H14.7753C15.2866 20.9501 15.696 20.3962 15.9762 19.7754C16.2564 19.1546 16.4009 18.4812 16.4001 17.8001V15.4001C16.4001 14.1271 15.8944 12.9062 14.9942 12.006C14.094 11.1058 12.8731 10.6001 11.6001 10.6001H9.2001C8.51899 10.5993 7.84556 10.7438 7.22475 11.024C6.60395 11.3042 6.05007 11.7136 5.6001 12.2249V8.2001ZM9.2001 11.8001C8.24532 11.8001 7.32964 12.1794 6.65451 12.8545C5.97938 13.5296 5.6001 14.4453 5.6001 15.4001V17.8001C5.6001 18.7549 5.97938 19.6706 6.65451 20.3457C7.32964 21.0208 8.24532 21.4001 9.2001 21.4001H11.6001C12.5549 21.4001 13.4706 21.0208 14.1457 20.3457C14.8208 19.6706 15.2001 18.7549 15.2001 17.8001V15.4001C15.2001 14.4453 14.8208 13.5296 14.1457 12.8545C13.4706 12.1794 12.5549 11.8001 11.6001 11.8001H9.2001Z"
                            fill="#currentColor" />
                    </svg>
                    <p>Serbaguna</p>
                </a>
                <a href="/dashboard/dapur" class="card-sidebar {{Request::is('dashboard/dapur') ? 'active' : ''}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="30" viewBox="0 0 24 24"
                        fill="none">
                        <path
                            d="M8.192 8H9.192V5.385H8.192V8ZM8.192 16.115H9.192V11.77H8.192V16.115ZM6.615 21C6.171 21 5.791 20.8417 5.475 20.525C5.15833 20.209 5 19.829 5 19.385V10.385H19V19.385C19 19.8317 18.8417 20.2127 18.525 20.528C18.209 20.8427 17.829 21 17.385 21H6.615ZM5 9.385V4.615C5 4.171 5.15833 3.791 5.475 3.475C5.791 3.15833 6.171 3 6.615 3H17.385C17.829 3 18.209 3.15833 18.525 3.475C18.8417 3.791 19 4.171 19 4.615V9.385H5Z"
                            fill="#currentColor" />
                    </svg>
                    <p>Kitchen</p>
                </a>
                <a href="/dashboard/theatre" class="card-sidebar {{Request::is('dashboard/theatre') ? 'active' : ''}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 26 26"
                        fill="none">
                        <path
                            d="M7.16633 21.6669C6.68533 21.6669 6.27366 21.4954 5.93133 21.1523C5.58828 20.81 5.41675 20.3983 5.41675 19.9173V11.1672C5.41675 10.8899 5.47886 10.6274 5.60308 10.3797C5.72658 10.1319 5.89775 9.92754 6.11658 9.76648L11.9503 5.3714C12.2551 5.13812 12.6039 5.02148 12.9968 5.02148C13.389 5.02148 13.74 5.13812 14.0498 5.3714L19.8836 9.76648C20.1024 9.92754 20.2736 10.1319 20.3971 10.3797C20.5213 10.6274 20.5834 10.8899 20.5834 11.1672V11.9169H13.5829C12.9871 11.9169 12.4772 12.1292 12.0532 12.5539C11.6293 12.9786 11.417 13.4885 11.4162 14.0836V18.4169C11.4162 19.0127 11.6286 19.523 12.0532 19.9477C12.4779 20.3723 12.9878 20.5843 13.5829 20.5836H20.0417C20.1956 20.5836 20.3241 20.6356 20.4274 20.7396C20.5307 20.8436 20.5827 20.9721 20.5834 21.1252C20.5834 21.2783 20.5314 21.4069 20.4274 21.5109C20.3241 21.6142 20.1956 21.6658 20.0417 21.6658L7.16633 21.6669ZM13.5829 19.0832C13.3944 19.0832 13.2362 19.0192 13.1084 18.8914C12.9806 18.7643 12.9167 18.6061 12.9167 18.4169V14.0836C12.9167 13.8943 12.9806 13.7362 13.1084 13.6091C13.2362 13.4812 13.3944 13.4173 13.5829 13.4173H17.9162C18.1055 13.4173 18.264 13.4812 18.3918 13.6091C18.5197 13.7362 18.5836 13.8943 18.5836 14.0836V15.6674L19.9442 14.9567C20.0966 14.8802 20.2411 14.8852 20.3776 14.9719C20.5148 15.0586 20.5834 15.1813 20.5834 15.3402V17.1602C20.5834 17.3191 20.5148 17.4419 20.3776 17.5286C20.2411 17.6152 20.0966 17.6203 19.9442 17.5437L18.5836 16.8331V18.4169C18.5836 18.6061 18.5197 18.7643 18.3918 18.8914C18.264 19.0192 18.1055 19.0832 17.9162 19.0832H13.5829Z"
                            fill="#currentColor" />
                    </svg>
                    <p>Theatre</p>
                </a>
                <a href="/dashboard/report" class="card-sidebar {{Request::is('dashboard/report') ? 'active' : ''}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="23" viewBox="0 0 25 23"
                        fill="none">
                        <g clip-path="url(#clip0_192_318)">
                            <path
                                d="M12.4999 4.98958L3.01512 13.3555C2.9448 13.4188 2.85496 13.4484 2.7777 13.5009V21.5278C2.7777 21.9115 3.08847 22.2222 3.47215 22.2222H9.94914L8.33326 19.0621L12.8519 16.2843L10.2408 11.1098L16.6666 17.0464L12.1479 19.8242L13.8806 22.2222H21.5277C21.9114 22.2222 22.2221 21.9115 22.2221 21.5278V13.5026C22.1484 13.4523 22.0607 13.4236 21.9938 13.3637L12.4999 4.98958ZM24.7695 10.2552L22.2221 8.00564V2.08333C22.2221 1.69965 21.9114 1.38889 21.5277 1.38889H18.7499C18.3662 1.38889 18.0555 1.69965 18.0555 2.08333V4.32682L13.6609 0.447484C13.3298 0.149741 12.9149 0.000434977 12.4999 9.49039e-07C12.085 -0.000433079 11.6709 0.148004 11.3411 0.445747L0.230393 10.2552C-0.0547635 10.5117 -0.078635 10.9505 0.177875 11.2361L1.10669 12.27C1.36277 12.5551 1.80201 12.579 2.0876 12.3225L12.0407 3.54297C12.3033 3.31163 12.697 3.31163 12.9596 3.54297L22.9127 12.322C23.1978 12.5781 23.6371 12.5547 23.8936 12.2695L24.8224 11.2357C25.0785 10.9505 25.055 10.5113 24.7695 10.2552Z"
                                fill="#currentColor" />
                        </g>
                        <defs>
                            <clipPath id="clip0_192_318">
                                <rect width="25" height="22.2222" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                    <p>Report</p>
                </a>
                <a href="/dashboard/penghuni" class="card-sidebar {{Request::is('dashboard/penghuni') ? 'active' : ''}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="30" viewBox="0 0 30 30" fill="none">
                        <path d="M10 15C11.3261 15 12.5979 14.4732 13.5355 13.5355C14.4732 12.5979 15 11.3261 15 10C15 8.67392 14.4732 7.40215 13.5355 6.46447C12.5979 5.52678 11.3261 5 10 5C8.67392 5 7.40215 5.52678 6.46447 6.46447C5.52678 7.40215 5 8.67392 5 10C5 11.3261 5.52678 12.5979 6.46447 13.5355C7.40215 14.4732 8.67392 15 10 15ZM21.25 15C22.2446 15 23.1984 14.6049 23.9017 13.9017C24.6049 13.1984 25 12.2446 25 11.25C25 10.2554 24.6049 9.30161 23.9017 8.59835C23.1984 7.89509 22.2446 7.5 21.25 7.5C20.2554 7.5 19.3016 7.89509 18.5983 8.59835C17.8951 9.30161 17.5 10.2554 17.5 11.25C17.5 12.2446 17.8951 13.1984 18.5983 13.9017C19.3016 14.6049 20.2554 15 21.25 15ZM5.3125 17.5C4.56658 17.5 3.85121 17.7963 3.32376 18.3238C2.79632 18.8512 2.5 19.5666 2.5 20.3125V20.625C2.5 20.625 2.5 26.25 10 26.25C17.5 26.25 17.5 20.625 17.5 20.625V20.3125C17.5 19.5666 17.2037 18.8512 16.6762 18.3238C16.1488 17.7963 15.4334 17.5 14.6875 17.5H5.3125ZM21.25 24.375C19.7862 24.375 18.665 24.1488 17.8062 23.8025C18.306 22.959 18.6197 22.0184 18.7262 21.0437C18.7384 20.9253 18.7463 20.8065 18.75 20.6875V20.3125C18.7516 19.2653 18.3475 18.2582 17.6225 17.5025C17.665 17.5007 17.7075 17.4999 17.75 17.5H24.75C25.4793 17.5 26.1788 17.7897 26.6945 18.3055C27.2103 18.8212 27.5 19.5207 27.5 20.25C27.5 20.25 27.5 24.375 21.25 24.375Z" fill="#currentColor"/>
                      </svg>
                    <p>User</p>
                </a>
            </div>
        </div>
        <div class="menu-toggle">
            <input type="checkbox">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    @vite('resources/js/sidebar.js')
</body>

</html>
