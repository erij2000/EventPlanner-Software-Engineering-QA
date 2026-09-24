def test_event_name_valid():
    event_name = "My Event"
    assert len(event_name) > 3


def test_event_capacity_positive():
    capacity = 50
    assert capacity > 0
