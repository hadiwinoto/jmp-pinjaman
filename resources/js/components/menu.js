export const menuItems = [
    {
        id: 1,
        label: "Menu",
        isTitle: true
    },
    {
        id: 2,
        label: "Dashboard",
        icon: "bx-home-circle",
        link: "/",
        // badge: {
        //     variant: "info",
        //     text: "menuitems.dashboards.badge"
        // },
    },
    {
        id: 3,
        label: "Kelola Pinjaman",
        icon: "bx-receipt",
        link: "/kasbon",
        // subItems: [
        //     {
        //         id: 31,
        //         label: "menuitems.invoices.list.invoicelist",
        //         link: "/",
        //         parentId: 30
        //     },
        //     {
        //         id: 32,
        //         label: "menuitems.invoices.list.invoicedetail",
        //         link: "/",
        //         parentId: 30
        //     }
        // ]
    },
    {
        id: 4,
        label: "Management",
        icon: "bx bxs-user-detail",
        link: "/user-management",
        subItems: [
            {
                id: 5,
                label: "Karyawan",
                link: "/user-management",
                parentId: 4
            },
            {
                id: 6,
                label: "Master Data",
                link: "/",
                parentId: 4
            }
        ]
    }
];
