const ElementViewer = BX.namespace('ElementViewer');

ElementViewer.init = function (sliderUrl) {

    const cell = this.findCell();

    cell.forEach(item => {

        let itemChild = item.children;
        let child = itemChild[0];

        if(child && child.tagName === 'A') {
            const listData = this.extractListData(child.toString());

            if(listData !== undefined) {
                child.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.openSlider(sliderUrl, listData.list_id, listData.element_id);
                })
            }
        }
    });

}

ElementViewer.pattern = '/lists/(\\d+)/element/(\\d+)/(\\d+)';

ElementViewer.extractListData = function (url) {
    let match = url.match(this.pattern);
    if(match) {

        let result = {
            list_id: Number(match[1]),
            element_id: Number(match[3])
        };

        if(Number(match[2]) > 0) {
            result.section_id = Number(match[2]);
        }

        return result;
    }
}

ElementViewer.openSlider = function (sliderUri, listId, elementId) {

    let sliderParams = {
        list_id: listId,
        element_id: elementId
    }

    return BX.SidePanel.Instance.open(sliderUri, {
        allowChangeHistory: false,
        cacheable: false,
        requestMethod: 'POST',
        requestParams: sliderParams
    });
}

ElementViewer.findCell = function () {
    return BX.findChildren(document, {
        class: 'main-grid-cell-content'
    }, true);
}

