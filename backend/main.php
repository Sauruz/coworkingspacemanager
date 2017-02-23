<?php

/** Step 2 (from text above). */
add_action('admin_menu', 'csm_menu');

/** Step 1. */
function csm_menu() {
    add_menu_page('Coworking Space Manager', 'Coworking Space Manager', 'manage_options', 'coworking-space-manager', 'show_page', 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiIHdpZHRoPSI2MDBweCIgaGVpZ2h0PSI2MDBweCIgdmlld0JveD0iMCAwIDYwMCA2MDAiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDYwMCA2MDAiIHhtbDpzcGFjZT0icHJlc2VydmUiPjxnPjxwYXRoIGZpbGw9IiNGMjhBMDAiIGQ9Ik0yOTguNzk4LDIwNy4wNjFjMy41MzUsMC4wMTcsNS4xNzctMC43Myw1LjE1My00Ljc3MmMtMC4xNi0yNi4wOTgtMC4xNTItNTIuMTk5LTAuMDE0LTc4LjI5N2MwLjAyMS0zLjg3OC0xLjM0My00Ljg5OS01LjAyOS00Ljg5MmMtNDUuMzcxLDAuMDk4LTkwLjc0MywwLjExMi0xMzYuMTEzLTAuMDExYy00LjA2Mi0wLjAxLTUuMTU4LDEuMzMyLTUuMTM2LDUuMjVjMC4xNCwyNS43OTQsMC4xNjIsNTEuNTkyLTAuMDI0LDc3LjM4NmMtMC4wMjksNC4zMSwxLjM5NCw1LjM5MSw1LjUwNyw1LjM2YzIyLjQ1OC0wLjE3NCw0NC45MTYtMC4wODMsNjcuMzc0LTAuMDgxQzI1My4yNzcsMjA3LjAwNSwyNzYuMDM5LDIwNi45NTMsMjk4Ljc5OCwyMDcuMDYxeiIvPjxwYXRoIGZpbGw9IiNGMjhBMDAiIGQ9Ik00MTIuOTM4LDMyMy4yNTJjLTQuNjg4LTAuMTE3LTkuMzg0LTAuMDI2LTE0LjA3MS0wLjAzNWMtNC45OTQsMC05Ljk4OC0wLjA4Ny0xNC45OCwwLjAyNmMtNC41NDUsMC4xMDUtNy40NjQsMy4wNTMtNy41MjMsNy4zMTJjLTAuMDY3LDQuMjcyLDIuODIsNy41MDgsNy4yNzMsNy41NjljOS44MzMsMC4xNDEsMTkuNjcsMC4xMzYsMjkuNTA2LDAuMDAzYzQuNDM2LTAuMDU4LDcuMzU2LTMuMjk1LDcuMzE2LTcuNTQ2QzQyMC40MTgsMzI2LjM2Miw0MTcuNDU3LDMyMy4zNjcsNDEyLjkzOCwzMjMuMjUyeiIvPjxwYXRoIGZpbGw9IiNGMjhBMDAiIGQ9Ik00MTIuMDMyLDQxMC42NzZjLTQuMzktMC4wNTMtOC43NzYtMC4wMTEtMTMuMTYxLTAuMDFjLTQuNjkzLDAtOS4zODYtMC4wNC0xNC4wNzQsMC4wMWMtNS4yNTYsMC4wNTMtOC4zNjEsMi44MDUtOC40MzQsNy4zNjFjLTAuMDY5LDQuNTg0LDMuMDMxLDcuNTMyLDguMjAxLDcuNTdjOS4yMywwLjA2MiwxOC40NjEsMC4wNjQsMjcuNjg5LDAuMDA2YzUuMTc1LTAuMDMxLDguMjYyLTIuOTYxLDguMjA1LTcuNTdDNDIwLjQwOCw0MTMuNDg4LDQxNy4zMDIsNDEwLjczNCw0MTIuMDMyLDQxMC42NzZ6Ii8+PHBhdGggZmlsbD0iI0YyOEEwMCIgZD0iTTMwMC44ODEsNC4zN0MxMzcuODE0LDQuMzcsNS42MjIsMTM2LjU2Miw1LjYyMiwyOTkuNjNzMTMyLjE5MywyOTUuMjYsMjk1LjI1OSwyOTUuMjZjMTYzLjA2NywwLDI5NS4yNi0xMzIuMTkyLDI5NS4yNi0yOTUuMjZTNDYzLjk0OCw0LjM3LDMwMC44ODEsNC4zN3ogTTQ2My43OTMsNDU4LjE4NGMtMC4wMTIsNy41NzctMy4xOTcsMTAuNzY3LTEwLjc4NSwxMC43NzFjLTM2LjU1MywwLjAyLTczLjEwNCwwLjAyMi0xMDkuNjU5LTAuMDA1Yy02Ljk2LTAuMDAzLTEwLjMwOC0zLjM0Mi0xMC4zMTktMTAuMjk3Yy0wLjAzNy0xNy4yOTMtMC4wMjktMzQuNTgxLDAuMDAyLTUxLjg3NWMwLjAxLTYuOTk1LDMuMjk5LTEwLjI3NSwxMC4yOTctMTAuMjg4YzE4LjIwNi0wLjAyOSwzNi40MDQtMC4wMDksNTQuNjA0LTAuMDA5YzE4LjM1MiwwLDM2LjcwNS0wLjAxOSw1NS4wNTcsMC4wMDhjNy42MzcsMC4wMTIsMTAuNzk3LDMuMTU1LDEwLjgwNSwxMC43MzVDNDYzLjgxNyw0MjQuMjEsNDYzLjgyMSw0NDEuMTk3LDQ2My43OTMsNDU4LjE4NHogTTQ2My43OTMsMzcwLjc1M2MtMC4wMTIsNy41NTctMy4yMTEsMTAuNzQyLTEwLjgwMywxMC43NTNjLTE4LjM1MiwwLjAyMS0zNi43MDMsMC4wMDctNTUuMDU2LDAuMDA3Yy0xOC4wNDksMC0zNi4wOTcsMC4wMTUtNTQuMTQ0LTAuMDA3Yy03LjYxMi0wLjAxMS0xMC43NS0zLjE1Mi0xMC43NjItMTAuNzc3Yy0wLjAyNS0xNi45ODctMC4wMjUtMzMuOTcyLDAtNTAuOTZjMC4wMDgtNy42MDgsMy4xNDItMTAuNzI3LDEwLjc4Ny0xMC43MjljMzYuMzk4LTAuMDE2LDcyLjc5Ny0wLjAxNiwxMDkuMTk1LDBjNy41OTIsMC4wMDMsMTAuNzczLDMuMTg0LDEwLjc4MSwxMC43NTNDNDYzLjgxNywzMzYuNzgxLDQ2My44MjEsMzUzLjc2Niw0NjMuNzkzLDM3MC43NTN6IE01MDcuNTMzLDI5NC4zMzNjMCwxLjY4MywwLDMuNDI4LDAsNS4xNzRjLTAuMDAyLDU3LjIzNiwwLDExNC40NjktMC4wMDYsMTcxLjcwNGMtMC4wMDMsOS4xNzgtMy4xMzMsMTIuMzEyLTEyLjI3MSwxMi4zMjljLTE0LjkzOCwwLjAyNS0xNi40ODYtMS41MDQtMTYuNDg2LTE2LjI5N2MwLTU1LjU2NiwwLTExMS4xMywwLTE2Ni42OTRjMC0xLjk0NiwwLTMuODkxLDAtNi4xNjFjLTExNi43MzgsMC0yMzMuMDk4LDAtMzUwLjE5LDBjMCwxLjg0OCwwLDMuNzQ4LDAsNS42NDZjLTAuMDAxLDU3LjA4NCwwLDExNC4xNjctMC4wMDYsMTcxLjI0OWMwLDkuMTQ0LTMuMTM0LDEyLjI0NS0xMi4zMzMsMTIuMjU4Yy0xNC44ODcsMC4wMTctMTYuNDIzLTEuNTE4LTE2LjQyMi0xNi4zNmMwLjAwMi01NS43MTYsMC0xMTEuNDMyLDAtMTY3LjE0OWMwLTEuNzkzLDAtMy41ODYsMC01LjEyN2MtMC42MzctMC40LTAuODcyLTAuNjY5LTEuMTIyLTAuNjg2Yy0xMS41NDQtMC43MjEtMTMuNDUzLTIuNzY5LTEzLjQ1Mi0xNC40NjFjMC0xLjIxNS0wLjAxMy0yLjQyOSwwLjAwMi0zLjY0NWMwLjA5My03LjIwNiwzLjY5My0xMC43ODksMTEuMDI5LTEwLjc5NGMzMC45Ny0wLjAyMiw2MS45NC0wLjA5NCw5Mi45MTEsMC4wOTNjNC4wNzUsMC4wMjYsNi4yNTEtMS4xMDIsNy45NDUtNC44NjZjMy42NDctOC4xMDgsNy44MTctMTUuOTgsMTIuMDY0LTI0LjU0MWMtMi4yMzktMC4xLTMuODI3LTAuMjI5LTUuNDE2LTAuMjMxYy0xOC44MjQtMC4wMTMtMzcuNjUxLDAuMDA0LTU2LjQ3Ni0wLjAxNGMtMTEuODk4LTAuMDEyLTE4LjMyNC02LjM5LTE4LjMzLTE4LjIxN2MtMC4wMTUtMzYuMjgzLTAuMDE1LTcyLjU2OCwwLTEwOC44NTJjMC4wMDUtMTEuODc5LDYuMzkzLTE4LjI3MywxOC4yNi0xOC4yNzhjNTUuODY4LTAuMDEyLDExMS43MzctMC4wMTIsMTY3LjYwNS0wLjAwMWMxMS4xOTMsMC4wMDEsMTcuNzcsNi41NjgsMTcuNzc3LDE3LjgzNGMwLjAyNSwzNi43NCwwLjAyOSw3My40NzktMC4wMDIsMTEwLjIxOWMtMC4wMDgsMTAuNTU4LTYuNzkzLDE3LjI3MS0xNy40MTgsMTcuMjkxYy0xOC45NzcsMC4wMzQtMzcuOTU0LDAuMDA5LTU2LjkzMywwLjAwOWMtMS42NTgsMC0zLjMxOSwwLTUuNTQzLDBjMC41MjYsMS40NDIsMC44MTEsMi41MzEsMS4yOTgsMy41MjFjMy43NTMsNy42MDgsNy40MzQsMTUuMjU3LDExLjQxOCwyMi43NDRjMC43NiwxLjQyOCwyLjc1MywzLjEzMSw0LjE4MSwzLjEzNWM0NS4wODcsMC4xMjQsOTAuMTcxLDAuMDU0LDEzNS4yNTcsMC4wMDVjMC4xNDEsMCwwLjI3OS0wLjExMSwwLjYxNS0wLjI1NWMzLjI0OC0xNC4xNCwxNC43MTktMTcuOTM4LDI2LjkzMy0yMC40MTNjMi43NzEtMC41NjEsNC4xODctMS42MTEsNS4zNjQtMy45ODNjNy4wMDItMTQuMTAzLDE0LjE2Ni0yOC4xMjYsMjEuMTMxLTQyLjI0OWMwLjY2LTEuMzQ4LDEuMDY0LTMuODQzLDAuMzE2LTQuNzE5Yy04LjI3Ny05LjY3OC0xNi44MDMtMTkuMTQxLTI1LjQzOS0yOC44NjFjLTMuODYxLDIuOTg2LTYuMzk1LDUuODYxLTYuNjY0LDExLjE1MmMtMC4yMzEsNC40NTMtMi4zODEsOS00LjQ2NSwxMy4xMWMtMS45NTksMy44NjktNC42OCw0LjA3Ni03LjY5MSwxLjA5M2MtMTIuMDg0LTExLjk1OC0yNC4xMDktMjMuOTgyLTM2LjA2Ni0zNi4wNjZjLTMuMjMtMy4yNjMtMy4wNjgtNS45NTYsMS4wODUtNy45NjFjNC40MDktMi4xMjcsOS4yNDYtMy42NjUsMTQuMDYzLTQuNTE3YzIuOTkzLTAuNTI5LDUuMzYzLTEuMTcsNy40NjgtMy40MzNjMy43MjEtMy45OTksNy42NjEtNy43OTUsMTEuNTYtMTEuNjI3YzguMTA3LTcuOTcxLDE4LjUxNi05LjA4OCwyNy4yNy0yLjk3NGM4LjIxNiw1LjczNywxMC40OSwxNS42NTUsNi4yODIsMjUuOTYxYy0wLjU1MiwxLjM1Ni0wLjEyNSwzLjg1NCwwLjgzOSw0Ljk3MmM5LjIwMywxMC43MDEsMTguNTk4LDIxLjIzNywyNy45ODIsMzEuNzc5YzQuNTEzLDUuMDcyLDQuODc1LDcuMjc5LDEuNzYyLDEzLjQ3M2MtNi41OTYsMTMuMTMtMTMuMjI3LDI2LjI0Mi0xOS44MzIsMzkuMzY4Yy0wLjg3NiwxLjc0NC0xLjY4OSwzLjUyMS0yLjcyNSw1LjY4NGMxMS4xMTcsMy42MjYsMjEuNDg4LDcuMzY3LDI0LjA1NSwyMC42MDJjMTAuNDc2LDAsMjAuOTI2LTAuMDEzLDMxLjM3NSwwLjAwNGM4Ljg0NiwwLjAxNCwxMS45OTIsMy4yMDgsMTIuMDA2LDEyLjExOGMwLjAwMiwwLjYwNiwwLjAwMiwxLjIxMywwLjAwMiwxLjgyMUM1MjIuMTAyLDI5MS41Nyw1MjAuNDQzLDI5My4zNzEsNTA3LjUzMywyOTQuMzMzeiIvPjwvZz48L3N2Zz4=', 2);
}

/** Step 3. */
function show_page() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    echo '<div class="wrap">';
    echo '<p>Here is where the form would go if I actually had options.</p>';
    echo '</div>';
}
