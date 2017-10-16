function flipper (force) {
    const body = document.body.classList
    let dark
    if (force === null || force === undefined) {
        dark = body.toggle('dark')
    } else {
        dark = body.toggle('dark', force)
    }

    window.localStorage.setItem('lightswitch', dark ? 'off' : 'on')
}

flipper(window.localStorage.getItem('lightswitch') === 'off')
Array.from(document.getElementsByClassName('lightswitch')).forEach((el) =>
    el.addEventListener('click', () => flipper())
)
