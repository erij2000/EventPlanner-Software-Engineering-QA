def test_password_min_length():
    password = "user1234"
    assert len(password) >= 8


def test_invalid_password():
    password = "123"
    assert len(password) < 8
