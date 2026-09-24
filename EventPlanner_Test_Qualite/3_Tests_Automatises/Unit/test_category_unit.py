def test_category_name_not_empty():
    category = "Wedding"
    assert category != ""


def test_category_creation():
    category = "Birthday"
    assert isinstance(category, str)
