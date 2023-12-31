const nl2br = (str) => {
    let res = str.replace(/\n/g, '<br>');
    res = res.replace(/(\n|\r)/g, '<br>');
    return res;
}

export { nl2br }
