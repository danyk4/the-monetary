import { Modal } from 'bootstrap'
import { get, post, del } from './ajax'
import DataTable from 'datatables.net'

window.addEventListener('DOMContentLoaded', function () {
    const editCategoryModal = new Modal(document.getElementById('editCategoryModal'))

    const table = new DataTable('#categoriesTable', {
        serverSide: true,
        ajax: '/categories/load',
        orderMulti: false,
        columns: [
            { data: 'name' },
            { data: 'createdAt' },
            { data: 'updatedAt' },
            {
                sortable: false,
                data: row => `
                    <div class="d-flex flex-">
                        <button type="submit" class="btn btn-outline-primary delete-category-btn" data-id="${row.id}">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                        <button class="ms-2 btn btn-outline-primary edit-category-btn" data-id="${row.id}">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                    </div>
                `,
            },
        ],
    })

    document.querySelector('#categoriesTable').addEventListener('click', function (event) {
        const editBtn = event.target.closest('.edit-category-btn')
        const deleteBtn = event.target.closest('.delete-category-btn')

        if (editBtn) {
            const categoryId = editBtn.getAttribute('data-id')

            get(`/categories/${categoryId}`).
            then(response => response.json()).
            then(response => openEditCategoryModal(editCategoryModal, response))
        } else {
            const categoryId = deleteBtn.getAttribute('data-id')

            if (confirm('Are you sure you want to delete this category?')) {
                del(`/categories/${categoryId}`).then(() => {
                    table.draw()
                })
            }
        }
    })

    document.querySelector('.save-category-btn').addEventListener('click', function (event) {
        const categoryId = event.currentTarget.getAttribute('data-id')

        post(`/categories/${categoryId}`, {
            name: editCategoryModal._element.querySelector('input[name="name"]').value,
        }, editCategoryModal._element).then(response => {
            if (response.ok) {
                table.draw()
                editCategoryModal.hide()
            }
        })
    })
})

function openEditCategoryModal (modal, { id, name }) {
    const nameInput = modal._element.querySelector('input[name="name"]')

    nameInput.value = name

    modal._element.querySelector('.save-category-btn').setAttribute('data-id', id)

    modal.show()
}

/*
import { Modal } from 'bootstrap'
import { get, post, del } from './ajax'
import DataTable from 'datatables.net'

window.addEventListener('DOMContentLoaded', function () {
    const editCategoryModal = new Modal(document.getElementById('editCategoryModal'))

    document.querySelectorAll('.edit-category-btn').forEach(button => {
        button.addEventListener('click', function (event) {
            const categoryId = event.currentTarget.getAttribute('data-id')

            get(`/categories/${categoryId}`).
            then(response => response.json()).
            then(response => openEditCategoryModal(editCategoryModal, response))

            /!*fetch(`/categories/${categoryId}`).then(res => res.json()).then(res => {
                openEditCategoryModal(editCategoryModal, res)
            })*!/
        })
    })

    document.querySelector('.save-category-btn').addEventListener('click', function (event) {
        const categoryId = event.currentTarget.getAttribute('data-id')
        // const csrfName = editCategoryModal._element.querySelector('input[name="csrf_name"]').value
        // const csrfValue = editCategoryModal._element.querySelector('input[name="csrf_value"]').value

        post(`/categories/${categoryId}`, {
            name: editCategoryModal._element.querySelector('input[name="name"]').value,
        }, editCategoryModal._element).then(response => {
            if (response.ok) {
                editCategoryModal.hide()
            }
        })

        /!*fetch(`/categories/${categoryId}`, {
            method: 'POST',
            body: JSON.stringify({
                name: editCategoryModal._element.querySelector('input[name="name"]').value,
                // csrf_name: csrfName,
                // csrf_value: csrfValue,
                ...getCsrfFields(),
            }),
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        }).then(res => console.log(res))*!/
    })

    document.querySelectorAll('.delete-category-btn').forEach(button => {
        button.addEventListener('click', function (event) {
            const categoryId = event.currentTarget.getAttribute('data-id')

            if (confirm('Are you sure you want to delete this category?')) {
                del(`/categories/${categoryId}`)
            }
        })
    })

})

function getCsrfFields () {
    const csrfNameField = document.querySelector('#csrfName')
    const csrfValueField = document.querySelector('#csrfValue')

    const csrfNameKey = csrfNameField.getAttribute('name')
    const csrfName = csrfNameField.content

    const csrfValueKey = csrfValueField.getAttribute('name')
    const csrfValue = csrfValueField.content

    return {
        [csrfNameKey]: csrfName, [csrfValueKey]: csrfValue,
    }
}

function openEditCategoryModal (modal, { id, name }) {
    const nameInput = modal._element.querySelector('input[name="name"]')

    nameInput.value = name

    modal._element.querySelector('.save-category-btn').setAttribute('data-id', id)

    modal.show()
}
*/
