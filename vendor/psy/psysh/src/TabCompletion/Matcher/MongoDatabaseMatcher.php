) {
                    function a() {}
                } else if (false) {
                    function a() {}
                } else {
                    function a() {}
                }
            '],
            // ewww
            ['
                function a() {}
                if (true):
                    function a() {}
                elseif (false):
                    function a() {}
                else:
                    function a() {}
                endif;
            '],
            ['
                function a() {}
                while (false) { function a() {} }
            '],
            ['
                function a() {}
                do { function a() {} } while (false);
            '],
            ['
                function a() {}
                switch (1) {
                    case 0:
                        function a() {}
                        break;
                    case 1:
                        function a() {}
                        break;
                    case 2:
                        function a() {}
                        break;
                }
            '],
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           