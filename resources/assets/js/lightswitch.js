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

document.getElementById('lightswitch').addEventListener('click', () => flipper())
flipper(window.localStorage.getItem('lightswitch') === 'off')
