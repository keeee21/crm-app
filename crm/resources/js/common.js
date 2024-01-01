const nl2br = (str) => {
    let res = str.replace(/\n/g, '<br>');
    res = res.replace(/(\n|\r)/g, '<br>');
    return res;
}

const getToday = () => {
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = ("0" + (1 + today.getMonth())).slice(-2);
    const dd = ("0" + today.getDate()).slice(-2);

    return yyyy + '-' + mm + '-' + dd;
}

export { nl2br, getToday }
