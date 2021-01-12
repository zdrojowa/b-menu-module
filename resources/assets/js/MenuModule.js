$(".add-menu-simple-structure").click(function () {
    Swal.mixin({
        progressSteps: ['1', '2'],
    }).queue([
        {
            title: "Nazwa",
            input: "text",
            preConfirm(inputValue) {
                if(!validateName(inputValue)) {
                    Swal.showValidationMessage(`Nazwa nie może być pusta`)
                }
            }
        },
        {
            title: "Wartość",
            input: "text",
        }
    ]).then(result => {
        let template = TEXT_TEMPLATE.split('%%type%%').join('Text').split('%%parentName%%').join('Tekst').split('%%value%%').join(result.value[1]).split('%%name%%').join(result.value[0]);

        $(".structure").append(template);
    })
})

$(".add-menu-structure").click(function () {
    Swal.fire({
        title: "Wybierz typ",
        html: generateTypeSelect()
    }).then((result) => {
        if(!result.value) return;

        const exploded = $("#select-type").val().split('::');
        generateNextStepForType(...exploded);
    })
});

$(".structure").sortable({handle: ".sortable"});

generateTypeSelect();

function generateTypeSelect() {
    let options = '';
    Object.keys(modulesMenusItems).forEach((name) => {
        const item = modulesMenusItems[name];

        options += generateSelectOption(name, item.type)
    });

    return `<select id="select-type" class="swal2-select">${options}</select>`;
}

function generateSelectOption(name, type) {
    return `<option value="${type}::${name}">${name}</option>`;
}

function generateNextStepForType(type, name) {
    switch (type) {
        case "Select":
            selectType(name);
            break;
        case "Blade":
            bladeType(name);
            break;
    }

}

function bladeType(name) {
    Swal.fire({
        title: "Nazwa",
        input: "text",
        preConfirm(inputValue) {
            if(!validateName(inputValue)) {
                Swal.showValidationMessage(`Nazwa nie może być pusta`)
            }
        }
    }).then(result => {
        let template = SELECT_TEMPLATE.split('%%type%%').join(modulesMenusItems[name].type).split('%%parentName%%').join(modulesMenusItems[name].name).split('%%value%%').join(modulesMenusItems[name].blade).split('%%name%%').join(result.value).split('%%data%%').join(JSON.stringify(modulesMenusItems[name].data));

        $(".structure").append(template);
    })
}

function selectType(name) {
    const select = makeSelectOptionsForType(modulesMenusItems[name].data, modulesMenusItems[name].optionName, modulesMenusItems[name].optionValue);


    Swal.mixin({
        progressSteps: ['1', '2'],
    }).queue([
        {
            input: "select",
            inputOptions: select
        },
        {
            title: "Nazwa",
            input: "text",
            preConfirm(inputValue) {
                if(!validateName(inputValue)) {
                    Swal.showValidationMessage(`Nazwa nie może być pusta`)
                }
            }
        }
    ]).then(result => {
        let template = SELECT_TEMPLATE.split('%%type%%').join(modulesMenusItems[name].type).split('%%parentName%%').join(modulesMenusItems[name].name).split('%%value%%').join(result.value[0]).split('%%name%%').join(result.value[1]).split('%%data%%').join(JSON.stringify(modulesMenusItems[name].data) || []);

        $(".structure").append(template);
    })
}

function makeSelectOptionsForType(data, name, value) {
    let select = [];

    data.forEach((item) => {
        select[item[value]] = item[name];
    });

    return select;
}

const TEXT_TEMPLATE = `
    <div class="structure-item col-md-12 d-flex" data-type="%%type%%" data-parent-name="%%parentName%%" data-name="%%name%%" data-value="%%value%%">
        <div class="sortable">
            <i class="mdi mdi-sort"></i>
        </div>
        <div class="item-content bg-primary text-white d-flex justify-content-between align-items-center">
            <div class="info">
                <div class="module-name">%%parentName%%</div>
                <div class="module-item-name">%%name%%</div>
            </div>
        <div class="actions">
                <i class="mdi mdi-trash-can"></i>
        </div>
        </div>
    </div>
`;


const SELECT_TEMPLATE = `
    <div class="structure-item col-md-12 d-flex" data-type="%%type%%" data-parent-name="%%parentName%%" data-name="%%name%%" data-value="%%value%%" data-data='%%data%%'>
        <div class="sortable">
            <i class="mdi mdi-sort"></i>
        </div>
        <div class="item-content bg-purple text-white d-flex justify-content-between align-items-center">
            <div class="info">
                <div class="module-name">%%parentName%%</div>
                <div class="module-item-name">%%name%%</div>
            </div>
        <div class="actions">
                <i class="mdi mdi-trash-can"></i>
        </div>
        </div>
    </div>
`;

function validateName(name) {
    if(name.length === 0) {
        return false;
    }

    return true;
}

function prepareStructure() {
    let structure = [];

    $(".structure-item").each((index, item) => {
        let object = {};

        object.type = $(item).data('type');
        object['parent-name'] = $(item).data('parent-name');
        object.name = $(item).data('name');
        object.value = $(item).data('value');
        object.data = $(item).data('data');

        structure.push(object);
    });

    return structure;
}

$(".save-button").click(function (e) {
   e.preventDefault();

   $('input[name=structure]').val(JSON.stringify(prepareStructure()));

   $(".form").submit();
});


function makeStructure() {
    if(structure !== null) {
        structure.forEach((item) => {
            if (item.type === "Text") {
                let template = TEXT_TEMPLATE.split('%%type%%').join(item.type).split('%%parentName%%').join(item['parent-name']).split('%%value%%').join(item.value).split('%%name%%').join(item.name);

                $(".structure").append(template);
            } else {
                let template = SELECT_TEMPLATE.split('%%type%%').join(item.type).split('%%parentName%%').join(item['parent-name']).split('%%value%%').join(item.value).split('%%name%%').join(item.name).split('%%data%%').join(item.data);

                $(".structure").append(template);
            }
        });
    }
}

makeStructure();

$(".mdi-trash-can").click(function () {
   $(this).closest('.structure-item').remove();
});
