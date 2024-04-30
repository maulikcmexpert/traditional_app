$(document).ready(function () {
    $("#example").DataTable();
    toastr.options = {
        closeButton: true,
        // Other options...
    };
});

$(document).on("click", ".mobile-toggle-menu", function () {
    $(".wrapper").addClass("toggled");
});
$(".progress-card").each(function () {
    var $bar = $(this).find(".bar");
    var $val = $(this).find("span");
    var perc = parseInt($val.text(), 10);

    $({ p: 0 }).animate(
        { p: perc },
        {
            duration: 3000,
            easing: "swing",
            step: function (p) {
                $bar.css({
                    transform: "rotate(" + (45 + p * 1.8) + "deg)", // 100%=180° so: ° = % * 1.8
                    // 45 is to add the needed rotation to have the green borders at the bottom
                });
                $val.text(p | 0);
            },
        }
    );
});

// $(document).ready(function() {
//     let myTable = $('#example').DataTable({
//         columnDefs: [{
//             orderable: false,
//             className: 'select-checkbox',
//             targets: 0,
//             responsive: true,
//         }],
//         select: {
//             style: 'os',
//             selector: 'td:first-child',
//         },
//         order: [
//             [1, 'asc'],
//         ],
//     });

//     $('#MyTableCheckAllButton').click(function() {
//         if (myTable.rows({
//                 selected: true
//             }).count() > 0) {
//             myTable.rows().deselect();
//             return;
//         }

//         myTable.rows().select();
//     });

//     myTable.on('select deselect', function(e, dt, type, indexes) {
//         if (type === 'row') {

//             if (dt.rows().count() === dt.rows({
//                     selected: true
//                 }).count()) {

//                 $('#MyTableCheckAllButton i').attr('class', 'far fa-check-square');
//                 return;
//             }

//             if (dt.rows({
//                     selected: true
//                 }).count() === 0) {

//                 $('#MyTableCheckAllButton i').attr('class', 'far fa-square');
//                 return;
//             }

//             $('#MyTableCheckAllButton i').attr('class', 'far fa-minus-square');
//         }
//     });
// });

// $(document).ready(function() {
//     let myTable = $('#transaction-table').DataTable({
//         columnDefs: [{
//             orderable: false,
//             className: 'select-checkbox',
//             targets: 0,
//             responsive: true,
//         }],
//         select: {
//             style: 'os',
//             selector: 'td:first-child',
//         },
//         order: [
//             [1, 'asc'],
//         ],
//     });

//     $('#MyTableCheckAllButton').click(function() {
//         if (myTable.rows({
//                 selected: true
//             }).count() > 0) {
//             myTable.rows().deselect();
//             return;
//         }

//         myTable.rows().select();
//     });

//     myTable.on('select deselect', function(e, dt, type, indexes) {
//         if (type === 'row') {

//             if (dt.rows().count() === dt.rows({
//                     selected: true
//                 }).count()) {

//                 $('#MyTableCheckAllButton i').attr('class', 'far fa-check-square');
//                 return;
//             }

//             if (dt.rows({
//                     selected: true
//                 }).count() === 0) {

//                 $('#MyTableCheckAllButton i').attr('class', 'far fa-square');
//                 return;
//             }

//             $('#MyTableCheckAllButton i').attr('class', 'far fa-minus-square');
//         }
//     });
// });

//--------- setting-side-navigation ------
function openNav() {
    document.getElementById("mySidenav").style.width = "420px";
    document.getElementById("overlay").style.display = "block";
    document.getElementById("mySidenav").classList.add("sideWrp");
    document.getElementById("mySidenav").classList.remove("sideWidth");
}
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("overlay").style.display = "none";
    document.getElementById("mySidenav").classList.remove("sideWrp");
    document.getElementById("mySidenav").classList.add("sideWidth");
}

$("#overlay").on("click", function () {
    $("#overlay").hide();
    $(".sidenav").width(0);
    $("#mySidenav").removeClass("sideWrp");
    $("#mySidenav").addClass("sideWidth");
});

// ========scrumboard-js======
const draggables = document.querySelectorAll(".scrumb-inner-content");
const droppables = document.querySelectorAll(".scrumb-inner-wrp");

draggables.forEach((task) => {
    task.addEventListener("dragstart", () => {
        task.classList.add("is-dragging");
    });
    task.addEventListener("dragend", () => {
        task.classList.remove("is-dragging");
    });
});

droppables.forEach((zone) => {
    zone.addEventListener("dragover", (e) => {
        e.preventDefault();

        const bottomTask = insertAboveTask(zone, e.clientY);
        const curTask = document.querySelector(".is-dragging");

        if (!bottomTask) {
            zone.appendChild(curTask);
        } else {
            zone.insertBefore(curTask, bottomTask);
        }
    });
});

const insertAboveTask = (zone, mouseY) => {
    const els = zone.querySelectorAll(
        ".scrumb-inner-content:not(.is-dragging)"
    );

    let closestTask = null;
    let closestOffset = Number.NEGATIVE_INFINITY;

    els.forEach((task) => {
        const { top } = task.getBoundingClientRect();

        const offset = mouseY - top;

        if (offset < 0 && offset > closestOffset) {
            closestOffset = offset;
            closestTask = task;
        }
    });

    return closestTask;
};

function openPopup(scrumbInnerId) {
    const popup = document.getElementById("popup");
    popup.style.display = "block";
    popup.dataset.scrumbInnerId = scrumbInnerId;
}

function closePopup() {
    const popup = document.getElementById("popup");
    popup.style.display = "none";
    document.getElementById("taskName").value = "";
}

function addNewTask() {
    const popup = document.getElementById("popup");
    const scrumbInnerId = popup.dataset.scrumbInnerId;
    const taskName = document.getElementById("taskName").value;

    if (taskName.trim() !== "") {
        const scrumbInner = document.getElementById(scrumbInnerId);
        const newTask = document.createElement("div");
        newTask.draggable = true;
        newTask.className = "scrumb-inner-content";
        newTask.textContent = taskName;

        newTask.addEventListener("dragstart", () => {
            newTask.classList.add("is-dragging");
        });
        newTask.addEventListener("dragend", () => {
            newTask.classList.remove("is-dragging");
        });

        scrumbInner.appendChild(newTask);
        closePopup(); // Close the popup after adding the task
    }
}

function openProjectNamePopup() {
    const projectNamePopup = document.getElementById("projectNamePopup");
    projectNamePopup.style.display = "block";
}

function closeProjectNamePopup() {
    const projectNamePopup = document.getElementById("projectNamePopup");
    projectNamePopup.style.display = "none";
    document.getElementById("projectName").value = "";
}

function addNewProject() {
    const projectNamePopup = document.getElementById("projectNamePopup");
    const projectName = document.getElementById("projectName").value;
    const droppables = document.querySelectorAll(".scrumb-inner-wrp");
    if (projectName.trim() !== "") {
        const scrumbMainWrp = document.querySelector(".scrumb-main-wrp");

        const newProject = document.createElement("div");
        const newtitle = document.createElement("h3");
        newtitle.textContent = projectName;
        newProject.appendChild(newtitle);
        newProject.className = "scrumb-inner-wrp";
        const newProjectId = `scrumb-inner-${droppables.length + 1}`;
        newProject.id = newProjectId;

        newProject.addEventListener("dragover", (e) => {
            e.preventDefault();

            const bottomTask = insertAboveTask(newProject, e.clientY);
            const curTask = document.querySelector(".is-dragging");

            if (!bottomTask) {
                newProject.appendChild(curTask);
            } else {
                newProject.insertBefore(curTask, bottomTask);
            }
        });

        // Add "Add New Task" button to the new project
        const addNewTaskButton = document.createElement("i");
        addNewTaskButton.className = "fa-solid fa-plus add-new-task";
        addNewTaskButton.onclick = function () {
            openPopup(newProjectId);
        };
        newProject.appendChild(addNewTaskButton);

        // Append the new project to the scrumb-main-wrp
        scrumbMainWrp.appendChild(newProject);

        closeProjectNamePopup(); // Close the project name popup after creating the project
    }
}
// ================================

$(document).ready(function () {
    $("#mycheckbox").change(function () {
        $(".product-shipping-hidden").toggle();
    });
});

$(document).ready(function () {
    // Add new variation
    $(".add-newvariation-btn").on("click", function (e) {
        e.preventDefault();
        var newVariation = $(".variation:first").clone();
        newVariation.find("select").prop("selectedIndex", 0);
        newVariation.find("input").val("");
        $(".edit-product-variation .product-category-select").append(
            newVariation
        );
    });

    // Delete variation
    $(".edit-product-variation .product-category-select").on(
        "click",
        ".delete-variation",
        function (e) {
            e.preventDefault();
            $(this).closest(".variation").remove();
        }
    );
});

//   -----checkout-image-choose---
var loadFile = function (event) {
    var output = document.getElementById("output");
    output.src = URL.createObjectURL(event.target.files[0]);
};

$(document).ready(function () {
    $(".choose-btn").click(function () {
        // $("input[type='file']").trigger('click');
    });
});

//   -----checkout-image-choose---
var loaduserprofile = function (event) {
    var output = document.getElementById("userprofile-output");
    output.src = URL.createObjectURL(event.target.files[0]);
};

$(document).ready(function () {
    $(".choose-user-profile-img").click(function () {
        // $("input[type='file']").trigger('click');
    });
});

const ul = document.querySelector(".product-tags-ul"),
    input = document.querySelector(".product-tags-input"),
    tagNumb = document.querySelector(".details span");

let maxTags = 10,
    tags = ["New", "Trending", "Sale"];
countTags();
createTag();

function countTags() {
    input.focus();
    tagNumb.innerText = maxTags - tags.length;
}

function createTag() {
    ul.querySelectorAll("li").forEach((li) => li.remove());
    tags.slice()
        .reverse()
        .forEach((tag, ind) => {
            let liTag = `<li>${tag} <i class="fa-solid fa-xmark tagRemove" data-index="${tag}" onclick="abc(this)"></i></li>`;
            ul.insertAdjacentHTML("afterbegin", liTag);
        });
    countTags();
}

function abc(th) {
    let tag = th.getAttribute("data-index");
    // tags = [...tags.slice(0, index), ...tags.slice(index + 1)];
    // tags = tags.filter((ele,ind)=>ind!== index )

    const index = tags.indexOf(tag);
    if (index > -1) {
        tags.splice(index, 1);
    }

    // tags.splice(index, 1); // 2nd parameter means remove one item only

    th.parentElement.remove();
    console.log({ tags });
    countTags();
}

// document.getElementsByClassName("tagRemove").addEventListener("click",()=>{
//   alert(1)
// })

function addTag(e) {
    if (e.key == "Enter") {
        let tag = e.target.value.replace(/\s+/g, " ");
        if (tag.length > 1 && !tags.includes(tag)) {
            if (tags.length < 10) {
                tag.split(",").forEach((tag) => {
                    tags.push(tag);
                    createTag();
                });
            }
        }
        e.target.value = "";
    }
}
input.addEventListener("keyup", addTag);

// const removeBtn = document.querySelector(".details button");
// removeBtn.addEventListener("click", () => {
//   tags.length = 0;
//   ul.querySelectorAll("li").forEach(li => li.remove());
//   countTags();
// });

let types = document.querySelectorAll(".d-type");
let per = document.getElementById(
    "kt_ecommerce_add_product_discount_percentage"
);
let fix = document.getElementById("kt_ecommerce_add_product_discount_fixed");

types.forEach((ele) => {
    ele.addEventListener("click", () => {
        types.forEach((el) => {
            el.classList.remove("active");
        });
        ele.classList.add("active");

        let rad = ele.getAttribute("data-type");
        if (rad == "percentage") {
            per.classList.remove("d-none");
            per.classList.add("d-block");

            // per.classList.remove("d-none");
            fix.classList.add("d-none");
        } else if (rad == "fixed") {
            fix.classList.remove("d-none");
            fix.classList.add("d-block");

            per.classList.add("d-none");
        } else {
            fix.classList.add("d-none");
            per.classList.add("d-none");
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    var e = document.getElementsByClassName("code-switcher");
    Array.from(e).forEach(function (a) {
        a.addEventListener("change", function () {
            var e = a.closest(".card"),
                t = e.querySelector(".live-preview"),
                e = e.querySelector(".code-view");
            a.checked
                ? (t.classList.add("d-none"), e.classList.remove("d-none"))
                : (t.classList.remove("d-none"), e.classList.add("d-none"));
        });
    }),
        feather.replace();
});

var imgUpload = document.getElementById("upload-img"),
    imgPreview = document.getElementById("img-preview"),
    imgUploadForm = document.getElementById("form-upload"),
    totalFiles,
    previewTitle,
    previewTitleText,
    img;

imgUpload.addEventListener("change", previewImgs, true);

function previewImgs(event) {
    totalFiles = imgUpload.files.length;

    if (!!totalFiles) {
        imgPreview.classList.remove("img-thumbs-hidden");
    }

    for (var i = 0; i < totalFiles; i++) {
        wrapper = document.createElement("div");
        wrapper.classList.add("wrapper-thumb");
        removeBtn = document.createElement("span");
        nodeRemove = document.createTextNode("x");
        removeBtn.classList.add("remove-btn");
        removeBtn.appendChild(nodeRemove);
        img = document.createElement("img");
        img.src = URL.createObjectURL(event.target.files[i]);
        img.classList.add("img-preview-thumb");
        wrapper.appendChild(img);
        wrapper.appendChild(removeBtn);
        imgPreview.appendChild(wrapper);

        $(".remove-btn").click(function () {
            $(this).parent(".wrapper-thumb").remove();
            checkEmptyAndHide();
        });
    }

    checkEmptyAndHide();
}

function checkEmptyAndHide() {
    var wrappers = document.getElementsByClassName("wrapper-thumb");
    if (wrappers.length === 0) {
        imgPreview.classList.add("img-thumbs-hidden");
    }
}

function errorAlert(moduleName) {
    swal({
        title: `Error`,
        text:
            "User(s) belongs to deleted " +
            moduleName +
            ". can not delete " +
            moduleName,
        icon: "error",
    });
}

function OrganizationerrorAlert(moduleName) {
    swal({
        title: `Error`,
        text:
            "Church/Organization(s) belongs to deleted " +
            moduleName +
            ". can not delete " +
            moduleName,
        icon: "error",
    });
}
