fos.Router.setData({"base_url":"","routes":{"bms_index":{"tokens":[["text","\/bms\/"]],"defaults":[],"requirements":[],"hosttokens":[]},"bms_change_page":{"tokens":[["text","\/bms\/"]],"defaults":[],"requirements":[],"hosttokens":[]},"bms_visualization_add_page":{"tokens":[["text","\/bms_admin\/wizualizacja\/add_page"]],"defaults":[],"requirements":[],"hosttokens":[]},"bms_visualization_delete_page":{"tokens":[["text","\/bms_admin\/wizualizacja\/delete_page"]],"defaults":[],"requirements":[],"hosttokens":[]},"bms_visualization_change_page":{"tokens":[["text","\/bms_admin\/wizualizacja\/change_page"]],"defaults":[],"requirements":[],"hosttokens":[]},"bms_visualization_add_panel":{"tokens":[["text","\/bms_admin\/wizualizacja\/add_panel"]],"defaults":[],"requirements":[],"hosttokens":[]},"bms_visualization_edit_panel":{"tokens":[["text","\/bms_admin\/wizualizacja\/edit_panel"]],"defaults":[],"requirements":[],"hosttokens":[]},"bms_visualization_edit_area_panel":{"tokens":[["text","\/bms_admin\/wizualizacja\/edit_area_panel"]],"defaults":[],"requirements":[],"hosttokens":[]},"bms_visualization_edit_text_panel":{"tokens":[["text","\/bms_admin\/wizualizacja\/edit_text_panel"]],"defaults":[],"requirements":[],"hosttokens":[]},"bms_visualization_edit_image_panel":{"tokens":[["text","\/bms_admin\/wizualizacja\/edit_image_panel"]],"defaults":[],"requirements":[],"hosttokens":[]},"bms_visualization_edit_variable_panel":{"tokens":[["text","\/bms_admin\/wizualizacja\/edit_variable_panel"]],"defaults":[],"requirements":[],"hosttokens":[]},"bms_visualization_delete_panel":{"tokens":[["text","\/bms_admin\/wizualizacja\/delete_panel"]],"defaults":[],"requirements":[],"hosttokens":[]},"bms_visualization_load_variable_settings_panel":{"tokens":[["text","\/bms_admin\/wizualizacja\/load_variable_settings_panel"]],"defaults":[],"requirements":[],"hosttokens":[]},"bms_configuration_index":{"tokens":[["text","\/bms_admin\/konfiguracja\/"]],"defaults":[],"requirements":[],"hosttokens":[]},"bms_configuration_communication_type":{"tokens":[["variable","\/","\\d+","comm_id"],["text","\/bms_admin\/konfiguracja"]],"defaults":[],"requirements":{"comm_id":"\\d+"},"hosttokens":[]},"bms_configuration_device":{"tokens":[["variable","\/","\\d+","device_id"],["variable","\/","\\d+","comm_id"],["text","\/bms_admin\/konfiguracja"]],"defaults":[],"requirements":{"comm_id":"\\d+","device_id":"\\d+"},"hosttokens":[]},"bms_configuration_register":{"tokens":[["variable","\/","\\d+","register_id"],["variable","\/","\\d+","device_id"],["variable","\/","\\d+","comm_id"],["text","\/bms_admin\/konfiguracja"]],"defaults":[],"requirements":{"comm_id":"\\d+","device_id":"\\d+","register_id":"\\d+"},"hosttokens":[]},"bms_configuration_add_device":{"tokens":[["text","\/add_device"],["variable","\/","\\d+","comm_id"],["text","\/bms_admin\/konfiguracja"]],"defaults":[],"requirements":{"comm_id":"\\d+"},"hosttokens":[]},"bms_configuration_add_register":{"tokens":[["text","\/add_register"],["variable","\/","\\d+","device_id"],["variable","\/","\\d+","comm_id"],["text","\/bms_admin\/konfiguracja"]],"defaults":[],"requirements":{"comm_id":"\\d+","device_id":"\\d+"},"hosttokens":[]},"bms_configuration_refresh_page":{"tokens":[["text","\/refresh"],["variable","\/","\\d+","register_id"],["variable","\/","\\d+","device_id"],["variable","\/","\\d+","comm_id"],["text","\/bms_admin\/konfiguracja"]],"defaults":[],"requirements":{"comm_id":"\\d+","device_id":"\\d+","register_id":"\\d+"},"hosttokens":[]},"app_admin_select_target":{"tokens":[["text","\/admin\/select_target"]],"defaults":[],"requirements":[],"hosttokens":[]}},"prefix":"","host":"localhost","scheme":"http"});